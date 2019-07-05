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