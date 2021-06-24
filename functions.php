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
    'hierarchical' => false,
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
  ];
  return $new_rules + $rules;
}

//WordPress標準のカテゴリーウィジェットを拡張して
//カスタムタクソノミーを選択できるようにする
add_action( 'widgets_init', 'museum_widget_cagegories' );
function museum_widget_cagegories() {
  class WP_Widget_Categories_Taxonomy extends WP_Widget_Categories {
    private $taxonomy = 'category';

    public function widget( $args, $instance ) {
      if ( !empty( $instance['taxonomy'] ) ) {
        $this->taxonomy = $instance['taxonomy'];
      }

      add_filter( 'widget_categories_dropdown_args', array( $this, 'add_taxonomy_dropdown_args' ), 10 );
      add_filter( 'widget_categories_args', array( $this, 'add_taxonomy_dropdown_args' ), 10 );
      parent::widget( $args, $instance );
    }

    public function update( $new_instance, $old_instance ) {
      $instance = parent::update( $new_instance, $old_instance );
      $taxonomies = $this->get_taxonomies();
      $instance['taxonomy'] = 'category';
      if ( in_array( $new_instance['taxonomy'], $taxonomies ) ) {
        $instance['taxonomy'] = $new_instance['taxonomy'];
      }
      return $instance;
    }

    public function form( $instance ) {
      parent::form( $instance );
      $taxonomy = 'category';
      if ( !empty( $instance['taxonomy'] ) ) {
        $taxonomy = $instance['taxonomy'];
      }
      $taxonomies = $this->get_taxonomies();
      ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Taxonomy:' ); ?></label><br />
        <select id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
          <?php foreach ( $taxonomies as $value ) : ?>
          <option value="<?php echo esc_attr( $value ); ?>"<?php selected( $taxonomy, $value ); ?>><?php echo esc_attr( $value ); ?></option>
          <?php endforeach; ?>
        </select>
      </p>
      <?php
    }

    public function add_taxonomy_dropdown_args( $cat_args ) {
      $cat_args['taxonomy'] = $this->taxonomy;
      return $cat_args;
    }

    private function get_taxonomies() {
      $taxonomies = get_taxonomies( array(
        'public' => true,
      ) );
      return $taxonomies;
    }
  }
  unregister_widget( 'WP_Widget_Categories' );
  register_widget( 'WP_Widget_Categories_Taxonomy' );
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
    <h2 class="home-page-contents__heading -left">
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
      $description = get_the_author_meta( 'description', $atts['user_id'] );
      if ( $description !== '' ) : ?>
        <p class="home-page-contents__profile-description">
          <?php echo $description; ?>
        </p>
      <?php endif; ?>
    </div><!--.wrapper-->

    <?php
    $protocol = is_ssl() ? 'https' : 'http';
    $profile_link = esc_url( get_home_url( null, '', $protocol ) . '/profiles/' );
    ?>

    <a class="home-page-contents__profile-more-button button-1 -large" href="<?php echo $profile_link; ?>">
      MORE PROFILE
    </a>
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
    <h2 class="home-page-contents__heading -right">
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
                  <?php the_post_thumbnail(
                    'post-thumbnail',
                    [ 'data-object-fit' => 'contain',
                      'sizes' => '(max-width: 479px) calc(100vw - 80px), (max-width: 1023px) calc(50vw - 60px), calc((100vw - 250px) / 3 - 60px)' ] );
                  ?>
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
          <?php echo get_the_post_thumbnail(
            $post_obj->ID,
            'post-thumbnail',
            [ 'sizes' => '(max-width: 479px) 100vw, (max-width: 1023px) 50vw, calc((100vw - 250px) / 3)' ] );
          ?>
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