<div id="heroHeader" class="hero-header">

  <div class="hero-header__bg">

    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php $header_images = get_uploaded_header_images(); ?>

        <?php if ( $header_images ) : ?>
          <?php if ( get_theme_mod( 'header_image', '' ) === 'random-uploaded-image' ) shuffle( $header_images );
          foreach ( $header_images as $image ) : ?>
            <div class="swiper-slide">
              <img
                src="<?php echo esc_url( $image['url'] ); ?>"
                alt="<?php echo esc_attr( $image['alt_text'] ); ?>"
                width="<?php echo esc_attr( $image['width'] ); ?>"
                height="<?php echo esc_attr( $image['height'] ); ?>"
                data-object-fit="cover">
            </div>
          <?php endforeach; ?>

        <?php else : ?>
          <div class="swiper-slide">
            <img src="<?php echo esc_url( get_theme_support( 'custom-header', 'default-image' ) ); ?>" data-object-fit="cover">
          </div>
        <?php endif; ?>

      </div><!--.swiper-wrapper-->

      <div class="swiper-pagination"></div>
    </div><!--.swiper-container-->

    <svg class="hero-header__bg-grid-line-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1000 1000" height="1000" width="1000">
      <path d="M 200,0 V 1000"></path>
      <path d="M 400,0 V 1000"></path>
      <path d="M 600,0 V 1000"></path>
      <path d="M 800,0 V 1000"></path>
      <path d="M 0,200 H 1000"></path>
      <path d="M 0,400 H 1000"></path>
      <path d="M 0,600 H 1000"></path>
      <path d="M 0,800 H 1000"></path>
    </svg>
  </div><!--.hero-header__bg-->


  <div class="hero-header__heading">
    <h1 class="hero-header__heading-logo">
      <?php get_template_part('template_parts/logo'); ?>
    </h1>

    <p class="hero-header__heading-catch-copy">
      <?php bloginfo('description'); ?>
    </p>
  </div><!--.hero-header__heading-->

</div><!--.hero-header-->