<?php
/*
Template Name: ホームページ
*/
?>

<?php get_header(); ?>

<article id="homePageContents" class="home-page-contents">

  <?php if ( have_posts() ) : while ( have_posts() ) : if ( the_post() ); ?>

    <?php the_content(); ?>

  <?php endwhile; endif; ?>

</article><!--.home-page-contents-->

<?php get_footer(); ?>