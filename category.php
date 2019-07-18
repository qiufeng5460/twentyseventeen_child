<?php
/**
 * The template for displaying category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_child
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<!--20190701：创建了category.php-->

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
	if ( have_posts() ) :
    ?>
    <?php
	/* Start the Loop */
        //20190713:special display for faculty cat
        //20190717：use is_category fuction
        //$category=get_the_category();
        //if($category[0]->category_nicename!='faculty')
        if(is_category('faculty'))
        {
        while ( have_posts() ) :
	    the_post();
            get_template_part( 'template-parts/post/content', 'faculty' );
        endwhile;
        }
        else{
        while ( have_posts() ) :
	    the_post();
            get_template_part( 'template-parts/post/content', 'title' );
        endwhile; 
        }
        
	the_posts_pagination(
	    array(
	    'prev_text'          => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
	    'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
	    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
		)
	);
	else :
            get_template_part( 'template-parts/post/content', 'none' );
	endif;
    ?>
    </main><!-- article -->
    </div>
</div>


<?php
get_footer();
