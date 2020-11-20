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
  
  <section>
    <h2 class="main__heading-2">作品カテゴリー</h2>
    <div class="wrapper">
      <ul class="category-list">
        <?php wp_list_categories( [
          'show_option_all' => '全て',
          'orderby' => 'count',
          'hierarchival' => 0,
          'title_li' => '',
          'taxonomy' => 'works-category',
        ] ); ?>
      </ul>
    </div><!--.wrapper-->
  </section>

<?php get_footer(); ?>