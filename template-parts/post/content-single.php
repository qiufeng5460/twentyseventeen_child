<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_child
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
	the_title( '<h1 class="single-title">', '</h1>' );
    ?>
        <div class=single-date>      
        <?php echo get_the_date(); ?>
        </div>
    <?php
        the_content(
	    sprintf(
	    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
	    get_the_title()
	    )
	);

    ?>
    
</article><!-- #post-<?php the_ID(); ?> -->