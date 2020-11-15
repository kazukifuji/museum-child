<?php get_header(); ?>

  <article class="home-page-contents">

    <section class="home-page-contents__profile">
      <h2 class="home-page-contents__heading -center">
        <span class="home-page-contents__heading-text">Profile</span>
      </h2>
      
      <div class="wrapper">
        <figure class="home-page-contents__profile-avatar">
          <?php echo get_avatar( 1, 175 ); ?>
        </figure>

        <p class="home-page-contents__profile-name">
          <?php the_author_meta( 'display_name', 1 ); ?>
        </p>

        <?php
        $description = esc_html( get_the_author_meta( 'description', 1 ) );
        if ( $desc !== '' ) : ?>
          <p class="home-page-contents__profile-description">
            <?php echo $description; ?>
          </p>
        <?php endif; ?>
      </div><!--.wrapper-->
    </section>

    <section class="home-page-contents__works"></section>

    <section class="home-page-contents__blogs"></section>

    <div class="home-page-contents__social-media-accounts"></div>

  </article><!--.home-page-contents-->

<?php get_footer(); ?>