<?php get_header(); ?>

  <h1 class="main__heading-1" data-subtitle="- blogs -">ブログ</h1>

  <section>
    <div class="wrapper">
      <h2 class="main__heading-2">ブログ一覧</h2>
    </div><!--.wrapper-->
    <?php get_template_part('template_parts/post-list'); ?>
  </section>

<?php get_footer(); ?>