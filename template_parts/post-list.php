<?php if ( have_posts() ) : ?>
  <article id="postList" class="post-list">

    <div class="post-list__posts">

      <div class="post-list__posts-sizer"></div>

      <?php custom_the_prev_post_list_items( 'h3' ); ?>

      <?php while ( have_posts() ) : the_post(); ?>
        
        <?php custom_the_post_list_item( $post->ID, 'h3' ); ?>

      <?php endwhile; ?>

    </div><!--.post-list__posts-->

    <button class="post-list__show-more-button" type="button">SEE MORE</button>

    <div class="post-list__page-load-status">
      <div class="infinite-scroll-request">
        <div class="loader-ellips">
          <span class="loader-ellips__dot"></span>
          <span class="loader-ellips__dot"></span>
          <span class="loader-ellips__dot"></span>
          <span class="loader-ellips__dot"></span>
        </div>
      </div>
      <p class="infinite-scroll-last">End of content</p>
      <p class="infinite-scroll-error">No more pages to load</p>
    </div>

    <?php if ( $wp_query->max_num_pages > 1 ) : ?>
      <div class="post-list__navigation">

        <span class="post-list__navigation-prev-page-link">
          <?php previous_posts_link( '&lt; PREV PAGE' ); ?>
        </span>

        <span class="post-list__navigation-next-page-link">
          <?php next_posts_link( 'NEXT PAGE &gt;' ); ?>
        </span>

      </div><!--.post-list__navigation-->
    <?php endif; ?>

  </article><!--.post-list-->

<?php else : ?>

  <p class="main__error-text">No posts</p>

<?php endif; ?>