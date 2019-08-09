<?php
/**
 * Twenty Seventeen Child functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_Child
 * @since 1.0
 */

/**
 * 20190316:Enqueue scripts.
 */
function twentyseventeen_child_scripts() {

    //首页幻灯片
    wp_enqueue_script( 'plugslides', get_theme_file_uri( '/assets/js/plug.slides2.2.js' ), array( 'jquery' ), '2.1.2', true );
   
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_child_scripts' );

/*
 * 20190305:adds support for excerpts in pages
*/
function twentyseventeen_child_init() {
     add_post_type_support('page', 'excerpt');
}
add_action('init', 'twentyseventeen_child_init');

/*
 * 20190717:modify the default post number(10) for faculty cat by pre_get_posts
*/
function twentyseventeen_child_posts_faculty($query){
    //20190717:加判断不在admin中
    if(!is_admin()&&is_category('faculty')){
        $query->set('posts_per_page',9);
    }
}
add_filter('pre_get_posts','twentyseventeen_child_posts_faculty');
/*
 * 20190701:register left side menu. 
*/
function twentyseventeen_child_register_left_side_menu($starter_content){
   
	register_nav_menus( array(		
		'left' => __( 'Left Menu', 'twentyseventeen_child' ),
	) );
    return $starter_content;
}
add_filter( 'twentyseventeen_starter_content', 'twentyseventeen_child_register_left_side_menu');

/*
 * 20190701:wp_nav_menu_objects的filter中menu_item->current生效,获取当前menu_item存储于全局变量
*/
function twentyseventeen_child_find_current_menu($sorted_menu_items){


       foreach($sorted_menu_items as $menu_item){

            if($menu_item->current){
              
                $GLOBALS['current_menu_item'] = $menu_item;
                break;
            }
        }
        //20190701:对于分类list中的post link,选择某一条post时，没有current menu item为true。
        //所以此时以current_item_parent判断.即该条post对于的parent item.
        if(!isset($GLOBALS['current_menu_item'])){
            foreach($sorted_menu_items as $menu_item){

                if($menu_item->current_item_parent){

                    $GLOBALS['current_menu_item'] = $menu_item;
                    break;
                }
            }
        }
        
        //error_log(var_export($GLOBALS['current_menu_item'],true));
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'twentyseventeen_child_find_current_menu');

/*
 * 20190701:根据top menu被选择的item生成left menu,并把菜单的title单独处理
<nav class="left-navigation" > 
<div class="left_menu_title">走进七幼<"/div">   
<ul class="left_menu_item">
    <li class="left_current_item">园长寄语</li>
    <li>办园理念</li>
    <li>美丽七幼</li>
    <li>师资力量</li>
</ul>
</nav><!-- left-navigation -->
*/
function twentyseventeen_child_make_left_side_menu(){
        
        $parent_id=''; 
        $link='';
        $title='';
    
        $theme_location='top';
        $locations = get_nav_menu_locations();
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        
        $parent_id=$GLOBALS['current_menu_item']->menu_item_parent;
 
        //20190701:将父菜单添加到第一行，单独处理menu title
        $menu_list='<div class="left_menu_title">'."\n";    
        
        foreach($menu_items as $menu_item){
            
            if($parent_id==$menu_item->ID){
                $link=$menu_item->url;
                $title=$menu_item->title;
                
                $menu_list.=$title.'</div>'."\n";
            
                break;
            }
        }
        
        //20190701：随后依次添加子菜单
        $menu_list.='<ul class="left_menu_item">'."\n";
        
        foreach($menu_items as $menu_item){
            //20190701:查找当前所点击top子菜单的父菜单，所有该父菜单下的子菜单都需要到left菜单显示
            if($parent_id==$menu_item->menu_item_parent){
                $link=$menu_item->url;
                $title=$menu_item->title;
                
                //20190701:add .left_current_item for current item

                if($menu_item->ID==$GLOBALS['current_menu_item']->ID){
                   $menu_list.='<li class="left_current_item">'."\n";
                }
                else{
                   $menu_list.='<li>'."\n";
                }
                $menu_list.='<a href="'.$link.'">'.$title.'</a>' ."\n";
                $menu_list .= '</li>' ."\n";
                
            }
        }
        
        $menu_list .= '</ul>' ."\n";
        echo $menu_list;
}

/*20190217:获取当前菜单的title*/
function twentyseventeen_child_get_current_menu_title(){
    
    return $GLOBALS['current_menu_item']->title;
}

/**
 * 20190203：add breadcrumbs navi for 2017 child theme 
 *
 */
function twentyseventeen_child_breadcrumbs(){
    $delimiter=' » ';
    $before='<span class="current_crumb">';
    $after='</span>';
    
        $theme_location='top';
        $locations = get_nav_menu_locations();
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        
        $parent_id=$GLOBALS['current_menu_item']->menu_item_parent;
    
        foreach($menu_items as $menu_item){
            
            if($parent_id==$menu_item->ID){
                $parent_title=$menu_item->title;
                break;
            }
        }
        $menu_location=$before;
        $menu_location .=__('Current');
        $menu_location .="：   ";
        $menu_location .=__('Home');
        $menu_location .=$delimiter;
        $menu_location .=$parent_title;        
        $menu_location .=$delimiter;
        $menu_location .=$GLOBALS['current_menu_item']->title;
        $menu_location .=$after;
        
        echo $menu_location;
        //echo $before . '当前位置：   ' . '首页' . ' ' . $delimiter . ' '. $parent_title . ' ' . $delimiter . ' ' . $GLOBALS['current_menu_item']->title . $after;
    
}

/**
 * 20190720:
 * WordPress有原生的文章置顶功能，不过只支持在首页让置顶文章在顶部显示，
 * 其他如分类页、标签页、作者页和日期页等存档页面，就没法让置顶文章在顶部显示了，只能按默认的顺序显示。
 * 有很多网友早前向我问过怎么解决这样的问题，当时查阅了一些资料没有解决就被搁置了。
 * 现在参考wp-includes/query.php中首页置顶的代码，稍微修改一下，可以让分类页、标签页、
 * 作者页和日期页等存档页面也能像首页一样在顶部显示其范围内的置顶文章。
 * 把下面的代码放到当前主题下的functions.php中就可以了：
 * 原文出处：露兜博客 https://www.ludou.org/wordpress-sticky-posts-in-archive.html
 */

function putStickyOnTop($posts) {
   if(is_home() || !is_main_query() || !is_archive())
    return $posts;
    
  global $wp_query;

  // 获取所有置顶文章
  $sticky_posts = get_option('sticky_posts');
   
 
  if ( $wp_query->query_vars['paged'] <= 1 && !empty($sticky_posts) && is_array($sticky_posts) && !get_query_var('ignore_sticky_posts') ) {
//20190426：此处必须添加'numberposts' => -1，否则默认只会获取5个post
      $stickies1 = get_posts( array( 'post__in' => $sticky_posts,'numberposts' => -1 ) );

    foreach ( $stickies1 as $sticky_post1 ) {
      // 判断当前是否分类页 
      if($wp_query->is_category == 1 && !has_category($wp_query->query_vars['cat'], $sticky_post1->ID)) {

        // 去除不属于本分类的置顶文章
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_tag == 1 && !has_tag($wp_query->query_vars['tag'], $sticky_post1->ID)) {
        // 去除不属于本标签的文章
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_year == 1 && date_i18n('Y', strtotime($sticky_post1->post_date))!=$wp_query->query['m']) {
        // 去除不属于本年份的文章
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_month == 1 && date_i18n('Ym', strtotime($sticky_post1->post_date))!=$wp_query->query['m']) {
        // 去除不属于本月份的文章
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_day == 1 && date_i18n('Ymd', strtotime($sticky_post1->post_date))!=$wp_query->query['m']) {
        // 去除不属于本日期的文章
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_author == 1 && $sticky_post1->post_author != $wp_query->query_vars['author']) {
        // 去除不属于本作者的文章
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
    }


    $num_posts = count($posts);

    $sticky_offset = 0;
    // Loop over posts and relocate stickies to the front.
    for ( $i = 0; $i < $num_posts; $i++ ) {
      if ( in_array($posts[$i]->ID, $sticky_posts) ) {
        $sticky_post = $posts[$i];
        // Remove sticky from current position
        array_splice($posts, $i, 1);
        // Move to front, after other stickies
        array_splice($posts, $sticky_offset, 0, array($sticky_post));
        // Increment the sticky offset. The next sticky will be placed at this offset.
        $sticky_offset++;
        // Remove post from sticky posts array
        $offset = array_search($sticky_post->ID, $sticky_posts);
        unset( $sticky_posts[$offset] );
      }
    }

    // If any posts have been excluded specifically, Ignore those that are sticky.
    if ( !empty($sticky_posts) && !empty($wp_query->query_vars['post__not_in'] ) ){
       $sticky_posts = array_diff($sticky_posts, $wp_query->query_vars['post__not_in']);
    }

    // Fetch sticky posts that weren't in the query results
    if ( !empty($sticky_posts) ) {
      $stickies = get_posts( array(
        'post__in' => $sticky_posts,
        'post_type' => $wp_query->query_vars['post_type'],
        'post_status' => 'publish',
        'nopaging' => true
      ) );

      foreach ( $stickies as $sticky_post ) {
        array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
        $sticky_offset++;
      }
    }
  }
  
  return $posts;
}
add_filter('the_posts',  'putStickyOnTop' );

/**
 * 20190417：将附件（image）关联到一个页面，然后循环获取该页面的附件用以显示，比如在首页实现幻灯片等
 * 将附件分类后没有办法从分类直接获取附件？
 * 因为在plug.slides2.2.js中使用了slides的li，所以在function中固定li的class为sildes
 */
 
function twentyseventeen_child_get_attachment_in_post($post_slug=''){
     
    $image_slides='';
    //20190417:根据slug获取指定post的所有image附件
    if($post_slug){
       $media = get_attached_media( 'image', get_page_by_path($post_slug) );
       if(!$media)
       {echo "this is wrong post slug"; }
    }
    else{
        return;
    }
    
    foreach($media as $v){
       //20190417:根据attachment_id获取附件地址       
       $image_attributes = wp_get_attachment_image_src( $v->ID,'full' ); // 返回一个数组
       if( $image_attributes ) {

          $image_slides.='<li class="slides"><img src="'.$image_attributes[0].'"/></li>';
        } 
    }
    echo $image_slides;
}

/**
 * 20190413：在frontpage添加分类列表
 */
 
function twentyseventeen_child_postlist_frontpage($cat_slug=''){
        $cat_frontpage='';
        if($cat_slug){
        $cat=get_category_by_slug($cat_slug);
        if(!$cat){
            echo "It is wrong for category slug!";
        }
        else{
        //20190413:display cat name for post list in frontpage 
        $cat_frontpage = '<div class="cat_name_frontpage">';
        $cat_frontpage.= '<p>'.get_cat_name($cat->term_id).'</p>';
        $cat_frontpage.= '<a href="'.get_category_link($cat->term_id).'">>>></a>';
        $cat_frontpage.= '</div>'; 
        echo $cat_frontpage;
        
        //20190806:get post list in frontpage
        $args=array(
            'category_name'=>$cat_slug,
             'posts_per_page'=>'5'
         );
        $query=new WP_Query($args);
        if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();
            get_template_part( 'template-parts/frontpage/content', 'title' );
           }
        }
        wp_reset_postdata();
        
        }
        }
}