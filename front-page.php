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
<section class="the1row">
<div class="the1col_the1row leader_message_frontpage">
    <?php 
    $args_leader=array(
        'pagename'=>'leader_message'
    );
    $query_leader=new WP_Query($args_leader);
    if($query_leader->have_posts()){
        while($query_leader->have_posts()){
            $query_leader->the_post();
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
</section>
    <section class="the2row">
        <div class="the1col_the2row childhood_frontpage">
        <?php  twentyseventeen_child_postlist_frontpage('childhood'); ?>   
        </div>
        <div class="the2col_the2row education_frontpage">
        <?php  twentyseventeen_child_postlist_frontpage('education'); ?>    `
        </div>
    </section>
    
    
</div>

<section class="the3row">
    <div class="fixed_picture">
        
    </div>
</section>

<div class="wrap">
<section class="the4row">
        <div class="the1col_the4row exchange_frontpage">
        <?php  twentyseventeen_child_postlist_frontpage('exchange'); ?>   
        </div>
        <div class="the2col_the4row media_frontpage">
        <?php  twentyseventeen_child_postlist_frontpage('media'); ?>    `
        </div>
</section>
<section class="the5row">
    <div class="teachers">
        <div class="title">幼师风采</div>
        <a href="<?php echo get_category_link(get_category_by_slug('faculty')->term_id); ?>">
            <div class="show_box">
                <ul class="pic_box" id="pic_box">
                    <?php
                    $args=array(
                       'category_name'=>'faculty',
                       'posts_per_page'=>'10',
                       'orderby'=>'rand'
                    );
                    $query=new WP_Query($args);
                    if($query->have_posts()){
                        while($query->have_posts()){
                           $query->the_post();
                           $postid=get_the_ID();
                    ?>       
                           <li class="slides"><?php the_post_thumbnail(array(100,100));?></li><!-- #post-<?php the_ID(); ?> -->
                    <?php
                       }
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
                <div id="arr">
                    <span id="left"> <</span>
                    <span id="right">></span>
                </div>
            </div>
        </a>
    </div>
</section>
    <section class="the6row clue_frontpage">

            <?php 
            twentyseventeen_child_cat_in_polaroid('dream','7dream');
            twentyseventeen_child_cat_in_polaroid('parent_asistant','mama_story');
            twentyseventeen_child_cat_in_polaroid('parent_asistant','baba_teacher');
            ?>
    </section>
</div>

<?php
get_footer();