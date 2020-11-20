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