<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class( 'body' ); ?>>
    <?php wp_body_open(); ?>

    <header id="header" class="header">
      <h4 class="header__logo">
        <?php get_template_part( 'template_parts/logo' ); ?>
      </h4>

      <?php get_template_part( 'template_parts/hamburger-button' ); ?>
    </header>

    <?php get_sidebar(); ?>

    <div class="content">

      <div class="content__bg">
        <div id="backgroundCanvasWrap" class="content__bg-canvas-wrap">
          <canvas id="backgroundCanvas" class="content__bg-canvas"></canvas>
        </div>
      </div><!--.content__bg-->

      <div class="content__fg">

        <?php if ( is_home() || is_front_page() ) get_template_part( 'template_parts/hero-header' ); ?>

        <div class="main"> 