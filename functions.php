<?php
//子テーマのcss, jsファイルを追加読み込み
add_action( 'wp_enqueue_scripts', 'museum_child_enqueue_scripts', 20 );
function museum_child_enqueue_scripts() {
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/dist/css/style.css' );
  wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/dist/js/script.js', [], false, true );
}  