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