<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
<div class="the1row">
<div class="the1col_the1row leader_message_frontpage">
    <?php 
    $args=array(
        'pagename'=>'leader_message'
    );
    $query=new WP_Query($args);
    if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();
    ?>
    <article id="post-<?php the_ID();?>">
        <div class="leader_message_excerpt">
        <?php 
        the_post_thumbnail(array(120,166),array('class'=>'alignleft leader_message_thumbnail_frontpage'));
        the_excerpt();
        ?>
        </div>
        <a class="leader_message_more" href="<?php the_permalink();?>">更多>>>></a>
    </article> 

    <?php
        }
    }
    wp_reset_postdata();
    ?>
</div>
<div class="the2col_the1row slides_frontpage">
       
    <!--20190321:add slides in frontpage-->
    <!--20190804:将需要的图片src以img呈现，以便js获取，因为在js中无法使用wp函数-->
    <img id="slides_pre_next" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugslides/slider_pre_next.png" style="display:none">
    <img id="slides_nav_a" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugslides/slides_nav_a.png" style="display:none">
    <img id="slides_nav_a_cur" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugslides/slides_nav_a_cur.png" style="display:none">
    <!--20190804：设置将图片路径长宽，以便js获取相关参数-->
    <div id="advertisement" class="slides" style="width:540px;height:300px;">
        
        <ul class="slides" style="overflow:hidden;">
        <?php twentyseventeen_child_get_attachment_in_post('slides_frontpage');?>  
        </ul>   
    </div>
</div>    
</div>
</div>

<?php
get_footer();