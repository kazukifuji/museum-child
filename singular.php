<?php if ( is_attachment() ) wp_redirect( $post->guid ); ?>

<?php get_header(); ?>

  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

      <div class="wrapper -no-side-space -sp">

        <article <?php post_class('post-single'); ?>>

          <?php if ( has_post_thumbnail() ) : ?>
            <figure class="post-single__featured-media">
              <?php the_post_thumbnail(
                'post-thumbnail',
                [ 'data-object-fit' => 'contain',
                  'sizes' => '(max-width: 479px) 100vw, (max-width: 1023px) calc(100vw - 10vw), calc(100vw - 10vw - 250px)' ] );
              ?>
            </figure>
          <?php endif; ?>

          <div class="wrapper -no-side-space -pc -tc">
            <div class="post-single__body">

              <header class="post-single__header">

                <?php if ( is_single() ) : ?>
                  <div class="post-single__date">
                    <span class="post-single__date-icon">
                      <svg class="post-single__date-icon-svg" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                      </svg>
                    </span>

                    <time class="post-single__date-value"><?php echo esc_html( get_the_time( get_option('date_format') ) ); ?></time>
                  </div><!--.post-single__date-->
                <?php endif; ?>

                <?php the_title( '<h1 class="post-single__title">', '</h1>' ); ?>
              </header>

              <div class="post-single__content">
                <?php the_content( 'READ MORE', true ); ?>
                    
                <?php wp_link_pages([
                  'before' => '<div class="pagination">',
                  'after' => '</div>',
                ]); ?>
              </div><!--.post-single__content-->

              <?php if ( is_single() ) : ?>
                <footer class="post-single__footer">
                  <?php
                  $post_type = get_post_type();
                  if ( $post_type === 'works' ) $taxonomy = 'works-category';
                  else if ( $post_type === 'blogs' ) $taxonomy = 'blogs-category';
                  $terms = get_the_terms( $post->ID, $taxonomy );
                  
                  if ( $terms ) : ?>
                    <div class="post-single__taxonomy">
                      <span class="post-single__taxonomy-icon">
                        <svg class="post-single__taxonomy-icon-svg" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                          <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                      </span>

                      <ul class="post-single__taxonomy-list">
                        <?php foreach ( $terms as $term ) : ?>
                          <li class="post-single__taxonomy-list-item">
                            <a class="post-single__taxonomy-list-item-link" href="<?php echo esc_url( get_term_link($term) ); ?>">
                              <?php echo esc_html( $term->name ); ?>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div><!--.post-single__taxonomy-->
                  <?php endif; ?>

                </footer>
              <?php endif; ?>

            </div><!--.post-single__body-->
          </div><!--.wrapper-->

        </article>

      </div><!--.wrapper-->

    <?php endwhile; ?>
  <?php else : ?>

    <p class="main__error-text">No posts</p>

  <?php endif; ?>

  <?php if ( is_single() ) : ?>
    <div class="wrapper">
      <?php get_template_part('template_parts/posts-navigation'); ?>
    </div><!--.wrapper-->
  <?php endif; ?>
  
  <?php if ( comments_open() && !post_password_required() ) : ?>
    <div class="wrapper">
      <h2 class="main__heading-2">コメントフォーム</h2>
      <?php comments_template(); ?>
    </div><!--.wrapper-->
  <?php endif; ?>
  
<?php get_footer(); ?>