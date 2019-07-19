<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_child
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="wrap">
    <?php
	/* Start the Loop */
	while ( have_posts() ) :
	    the_post();
            get_template_part( 'template-parts/post/content', 'single' );
        endwhile; // End of the loop.
    ?>
    
</div>

<?php
get_footer();
