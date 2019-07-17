<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_child
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

    <div class="navigation-left">
	<?php get_template_part( 'template-parts/navigation/navigation', 'left' ); ?>
    </div>
    
    <div class="site-article">
        
    <div class="breadcrumbs_nav">
        <div class="breadcrumbs_title"><?php echo twentyseventeen_child_get_current_menu_title();  ?></div>
        <div class="breadcrumbs_path"><?php twentyseventeen_child_breadcrumbs() ?></div>
    </div>
 
    <main class="article-content">

    <?php

	/* Start the Loop */
	while ( have_posts() ) :
	    the_post();
            get_template_part( 'template-parts/page/content', 'page' );
        endwhile;
    ?>
    </main><!-- article -->
    </div>
</div>

<?php
get_footer();

