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

    <section class="home-page-contents__works">
      <h2 class="home-page-contents__heading -left">
        <span class="home-page-contents__heading-text">Works</span>
      </h2>

      <ul class="home-page-contents__works-list">
        <?php
        $post_id_arr = [ 1177, 1016, 1011, 555, 1163, 2135 ];

        foreach ( $post_id_arr as $post_id ) :
          if ( has_post_thumbnail( $post_id ) ) : ?>
            <li class="home-page-contents__works-list-item">
              <a class="home-page-contents__works-list-item-link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                <figure class="home-page-contents__works-list-item-featured-media">
                  <?php echo get_the_post_thumbnail( $post_id, 'post-thumbnail', [ 'data-object-fit' => 'cover' ] ); ?>
                </figure>
              </a>
            </li>
          <?php endif;
        endforeach ?>
      </ul>

      <a class="home-page-contents__works-more-button button-1 -large" href="<?php echo esc_url( get_post_type_archive_link( 'works' ) ); ?>">
        MORE WORKS
      </a>
    </section>

    <section class="home-page-contents__blogs"></section>

    <div class="home-page-contents__social-media-accounts"></div>

  </article><!--.home-page-contents-->

<?php get_footer(); ?>