<?php get_header(); ?>

  <h1 class="main__heading-1" data-subtitle="- works -">作品</h1>

  <section>
    <div class="wrapper">
      <h2 class="main__heading-2">
        <?php echo esc_html( get_queried_object()->name ); ?>
      </h2>
    </div><!--.wrapper-->
    <?php get_template_part('template_parts/post-list'); ?>
  </section>

<?php get_footer(); ?>