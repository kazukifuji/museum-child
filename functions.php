<?php
//子テーマのcss, jsファイルを追加読み込み
add_action( 'wp_enqueue_scripts', 'museum_child_enqueue_scripts', 20 );
function museum_child_enqueue_scripts() {
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/dist/css/style.css' );
  wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/dist/js/script.js', [], false, true );
}

//カスタムタクソノミーを作成
add_action( 'init', 'create_taxonomies' );
function create_taxonomies() {
  //作品カテゴリー
  register_taxonomy( 'works-category', 'works', [
    'labels' => [
      'name' => '作品カテゴリー',
      'all_items' => '作品カテゴリー一覧',
    ],
    'public' => true,
    'hierarchical' => true,
    'show_in_rest' => true,
  ] );

  //ブログカテゴリー
  register_taxonomy( 'blogs-category', 'blogs', [
    'labels' => [
      'name' => 'ブログカテゴリー',
      'all_items' => 'ブログカテゴリー一覧',
    ],
    'public' => true,
    'hierarchical' => true,
    'show_in_rest' => true,
  ] );
}

//カスタム投稿タイプを作成
add_action( 'init', 'create_post_types' );
function create_post_types() {
  //作品
  register_post_type( 'works', [
    'labels' => [
      'name' => '作品',
      'all_items' => '作品一覧',
    ],
    'public' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-format-image',
    'hierarchical' => true,
    'supports' => [
      'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks',
      'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats',
    ],
    'has_archive' => true,
    'show_in_rest' => true,
  ] );

  //ブログ
  register_post_type( 'blogs', [
    'labels' => [
      'name' => 'ブログ',
      'all_items' => 'ブログ一覧',
    ],
    'public' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-edit-large',
    'hierarchical' => true,
    'supports' => [
      'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks',
      'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats',
    ],
    'has_archive' => true,
    'show_in_rest' => true,
  ] );
}

//カスタム投稿のパーマリンクをカスタマイズ
add_filter( 'post_type_link', 'custom_post_type_link', 1, 2 );
function custom_post_type_link( $link, $post ) {
  //works
  if ( $post->post_type === 'works' ) {
    return home_url( '/works/' . $post->ID );

  //blogs
  } elseif ( $post->post_type === 'blogs' ) {
    return home_url( '/blogs/' . $post->ID );

  } else {
    return $link;
  }
}

//wp_list_categoriesをカスタマイズ
add_filter( 'wp_list_categories', 'custom_wp_list_categories', 10, 2 );
function custom_wp_list_categories( $output, $args ) {
  // 全てのカテゴリーにも、そのページの際にはcurrent-catクラスを適応
  if ( !strpos( $output, 'current-cat' ) ) {
    $output = str_replace( 'cat-item-all', 'cat-item-all current-cat', $output );
  }

  return $output;
}

//リトライルールを追加
add_filter( 'rewrite_rules_array', 'add_rewrite_rules' );
function add_rewrite_rules( $rules ) {
  $new_rules = [
    'works/([0-9]+)/?$' => 'index.php?post_type=works&p=$matches[1]',
    'blogs/([0-9]+)/?$' => 'index.php?post_type=blogs&p=$matches[1]',
  ];
  return $new_rules + $rules;
}

//WordPressのプロフィール欄でHTMLコードを使用する
remove_filter( 'pre_user_description', 'wp_filter_kses' );

//ホームページコンテンツのプロフィールセクションを表示するショートコード
add_shortcode( 'profile_section', 'museum_child_profile_section' );
function museum_child_profile_section( $atts ) {
  //属性の初期値を設定
  $atts = shortcode_atts( [ 'user_id' => 1 ], $atts, 'profile_section' );

  ob_start();
  ?>

  <section class="home-page-contents__profile">
    <h2 class="home-page-contents__heading -center">
      <span class="home-page-contents__heading-text">
        <span>P</span><span>r</span><span>o</span><span>f</span><span>i</span><span>l</span><span>e</span>
      </span>
    </h2>
    
    <div class="wrapper">
      <figure class="home-page-contents__profile-avatar">
        <?php echo get_avatar( $atts['user_id'], 175 ); ?>
      </figure>

      <p class="home-page-contents__profile-name">
        <?php the_author_meta( 'display_name', $atts['user_id'] ); ?>
      </p>

      <?php
      $description = esc_html( get_the_author_meta( 'description', $atts['user_id'] ) );
      if ( $description !== '' ) : ?>
        <p class="home-page-contents__profile-description">
          <?php echo $description; ?>
        </p>
      <?php endif; ?>
    </div><!--.wrapper-->
  </section>

  <?php
  return ob_get_clean();
}

//ホームページコンテンツの作品セクションを表示するショートコード
add_shortcode( 'works_section', 'museum_child_works_section' );
function museum_child_works_section( $atts ) {
  //属性の初期値を設定
  $atts = shortcode_atts( [ 'post_id_arr' => [] ], $atts, 'works_section' );

  //サブクエリを発行
  $works_query = new WP_Query( [
    'post_type' => 'works',
    'post_status' => 'publish',
    'post__in' => empty( $atts['post_id_arr'] ) ? [] : explode( ',', $atts['post_id_arr'] ),
    'posts_per_page' => empty( $atts['post_id_arr'] ) ? 6 : -1,
    'ignore_sticky_posts' => true,
  ] );
  
  ob_start();
  ?>
  
  <section class="home-page-contents__works">
    <h2 class="home-page-contents__heading -left">
      <span class="home-page-contents__heading-text">
        <span>W</span><span>o</span><span>r</span><span>k</span><span>s</span>
      </span>
    </h2>

    <ul class="home-page-contents__works-list">
      <?php 
      //サブループ
      if ( $works_query->have_posts() ) :
        while ( $works_query->have_posts() ) : $works_query->the_post();
          if ( has_post_thumbnail() ) : ?>
            <li class="home-page-contents__works-list-item">
              <a class="home-page-contents__works-list-item-link" href="<?php the_permalink(); ?>">
                <figure class="home-page-contents__works-list-item-featured-media">
                  <?php the_post_thumbnail( 'post-thumbnail', [ 'data-object-fit' => 'cover' ] ); ?>
                </figure>
              </a>
            </li>
          <?php endif;
        endwhile; wp_reset_postdata();
      endif; ?>
    </ul>

    <a class="home-page-contents__works-more-button button-1 -large" href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>">
      MORE WORKS
    </a>
  </section>
  
  <?php
  return ob_get_clean();
}

//ホームページコンテンツのブログセクションを表示するショートコード
add_shortcode( 'blogs_section', 'museum_child_blogs_section' );
function museum_child_blogs_section( $atts ) {
  //属性の初期値を設定
  $atts = shortcode_atts( [ 'post_id_arr' => [] ], $atts, 'blogs_section' );

  //サブクエリを発行
  $blogs_query = new WP_Query( [
    'post_type' => 'blogs',
    'post_status' => 'publish',
    'post__in' => empty( $atts['post_id_arr'] ) ? null : explode( ',', $atts['post_id_arr'] ),
    'posts_per_page' => empty( $atts['post_id_arr'] ) ? 8 : -1,
    'ignore_sticky_posts' => true,
  ] );

  ob_start();
  ?>

  <section class="home-page-contents__blogs">
    <h2 class="home-page-contents__heading -right">
      <span class="home-page-contents__heading-text">
        <span>B</span><span>l</span><span>o</span><span>g</span><span>s</span>
      </span>
    </h2>

    <div class="home-page-contents__blogs-swiper-container swiper-container">
      <div class="swiper-wrapper">
        <?php
        //サブループ
        if ( $blogs_query->have_posts() ) :
          while ( $blogs_query->have_posts() ) : $blogs_query->the_post(); ?>

            <div class="swiper-slide">
              <article class="swiper-slide-post">
                <?php if ( has_post_thumbnail() ) : ?>
                  <figure class="swiper-slide-post-thumbnail">
                    <?php the_post_thumbnail( 'post-thumbnail', [ 'data-object-fit' => 'cover' ] ); ?>
                  </figure>
                <?php endif; ?>

                <h3 class="swiper-slide-post-title">
                  <?php
                  $post_title = esc_html( get_the_title() );
                  if ( $post_title === '' ) $post_tile = 'No title';
                  echo $post_title;
                  ?>
                </h3>

                <p class="swiper-slide-post-excerpt">
                  <?php echo get_excerpt_text( null, 70 ); ?>
                </p>
                
                <a class="swiper-slide-post-link-button button-2 -small" href="<?php the_permalink(); ?>">MORE</a>
              </article>
            </div>

          <?php endwhile; wp_reset_postdata();
        endif; ?>
      </div>

    </div><!--.swiper-container-->
    
    <div class="swiper-pagination"></div>
    
    <a class="home-page-contents__blogs-more-button button-1 -large" href="<?php echo esc_url( get_post_type_archive_link( 'blogs' ) ); ?>">
      MORE BLOGS
    </a>
  </section>

  <?php
  return ob_get_clean();
}

//投稿の抜粋文を取得
function get_excerpt_text( $post_id = null, $length = 100 ) {
  $post_obj = get_post( $post_id );
  $excerpt_text = wp_html_excerpt( strip_shortcodes( $post_obj->post_content ), $length, '...' );
  return $excerpt_text;
}

//投稿リストの投稿アイテムを出力
//※引数「$post_id」を指定しない場合、現在の投稿を取得。
function custom_the_post_list_item( $post_id = null, $h_tag = 'h2' ) {
  //投稿オブジェクトを取得
  $post_obj = get_post( $post_id );
  ?>

  <article <?php post_class('post-item'); ?>>
          
    <a class="post-item__link" href="<?php the_permalink( $post_obj ); ?>">
    
      <?php if ( has_post_thumbnail( $post_obj->ID ) ) : ?>
        <figure class="post-item__featured-media">
          <?php echo get_the_post_thumbnail( $post_obj->ID, 'post-thumbnail', [ 'data-object-fit' => 'cover' ] ); ?>
        </figure><!--post-item__featured-media-->
      <?php endif; ?>

      <div class="post-item__content">

        <?php $post_title = esc_html( get_the_title( $post_obj ) );
        if ( $post_title !== '' ) : ?>
          <div class="post-item__content-header">
            <<?=$h_tag?> class="post-item__content-title">
              <?php echo $post_title; ?>
            </<?=$h_tag?>>
          </div><!--post-item__content-header-->
        <?php endif; ?>
        
        <div class="post-item__content-footer">
          <?php
          $taxonomy = get_object_taxonomies( $post_obj, 'names' )[0];
          $terms = get_the_terms( $post_obj->ID, $taxonomy );
          if ( $terms ) : ?>
            <div class="post-item__content-taxonomy">
              <span class="post-item__content-taxonomy-icon">
                <svg class="post-item__content-taxonomy-icon-svg" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                  <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
              </span>

              <ul class="post-item__content-taxonomy-list">
                <?php foreach ( $terms as $term ) : ?>
                  <li class="post-item__content-taxonomy-list-item"><?php echo esc_html( $term->name ); ?></li>
                <?php endforeach; ?>
              </ul>
            </div><!--.post-item__content-taxonomy-->
          <?php endif; ?>
        </div><!--post-item_content-footer-->
      
      </div><!--.post-item__content-->

    </a>

  </article><!--.post-item-->

  <?php
}

//'load_count'URLパラメータを元に、前のページの投稿リストの投稿アイテムを出力
function custom_the_prev_post_list_items( $h_tag = 'h2' ) {
  global $wp_query;

  if ( !isset( $_GET['load_count'] ) ) return;

  $load_count = (int) wp_unslash( $_GET['load_count'] );
  if ( $load_count <= 0 ) return;

  $current_page = (int) get_query_var('paged');
  if ( $current_page <= 0 ) $current_page = 1;

  $load_page = $current_page - $load_count;
  if ( $load_page <= 0 ) return;

  $args = $wp_query->query_vars;
  $args['paged'] = $load_page;
  $args['posts_per_page'] = $load_count * (int) get_option('posts_per_page');

  $query = new WP_Query( $args );

  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      custom_the_post_list_item( $query->post->ID, $h_tag );
    }
    wp_reset_postdata();
  }
}