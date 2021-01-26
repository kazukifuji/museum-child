        </main><!--.main-->

        <footer class="footer">
          <small class="footer__copyright">&copy; 2020-<?php echo date('Y'); ?> <?php the_author_meta( 'display_name', 1 ); ?> All rights reserved.</small>
        </footer>

      </div><!--.content__fg-->

    </div><!--.content-->
    
    <?php get_sidebar(); ?>

    <?php wp_footer(); ?>
  </body>
</html> 