<?php get_header(); ?>

  <h1 class="main__heading-1" data-subtitle="- works -">作品</h1>

  <div class="wrapper">
    <nav class="categories-nav">
      <ul class="categories-nav__category-list">
        <?php wp_list_categories( [
          'show_option_all' => '全て',
          'orderby' => 'count',
          'hierarchival' => 0,
          'title_li' => '',
          'taxonomy' => 'works-category',
        ] ); ?>
      </ul>
    </nav>
  </div><!--.wrapper-->

  <?php get_template_part('template_parts/post-list'); ?>

<?php get_footer(); ?>