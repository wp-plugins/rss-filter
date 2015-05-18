<?php
/*
Plugin Name: RSS Filter 
Plugin URI: http://wordpress.org/extend/plugins/rss-filter/
Description: RSS Filter plugin .You have option to customization your WordPress RSS feed items.
Version: 1.2
Author: Shambhu Prasad Patnaik
Author URI:http://socialcms.wordpress.com/
*/


if (!function_exists('post_editor_post_add_menus')) :
function post_editor_post_add_menus()
{
 add_menu_page('RSS Filter', 'RSS Filter', 'manage_options', __FILE__, 'rss_filter_admin_setting');
 add_submenu_page(__FILE__, 'Help', 'Help', 'manage_options', 'rss_filter_help','rss_filter_help');
}
endif;

add_action('admin_menu', 'post_editor_post_add_menus');

if (!function_exists('rss_filter_admin_setting')) :
function rss_filter_admin_setting()
{
 global $wpdb;
 $plugin_page= plugin_basename(__FILE__);
 $action_url=admin_url('admin.php?page='.$plugin_page);
 $myCsseUrl = plugins_url('stylesheet.css', __FILE__);
 $action ='';
 if(isset($_POST['update']))
 $action = stripslashes_deep($_POST['update']); 
 if($action=='Update')
 {
  $show_sticky      = stripslashes_deep($_POST['show_sticky']); 
  $exclude_category = stripslashes_deep($_POST['exclude_category']); 
  $exclude_post     = stripslashes_deep($_POST['exclude_post']); 
  $author_post      = stripslashes_deep($_POST['author_post']); 
  $rss_filter_setting =array('show_sticky'=>$show_sticky,'exclude_category'=>$exclude_category,'exclude_post'=>$exclude_post,'author_post'=>$author_post);
  $data=json_encode($rss_filter_setting);
  update_option('rss_filter_setting',$data); 
  update_option('rss_filter_message','Successfully Updated.');
  echo "<meta http-equiv='refresh' content='0;url=".$action_url."&message=update' />"; 
 }
 else
 {
  $data = json_decode(get_option('rss_filter_setting'));
  $setting_data = (array) json_decode(get_option('rss_filter_setting'));
  $show_sticky = $setting_data['show_sticky'];
  $exclude_category = $setting_data['exclude_category'];
  $exclude_post = $setting_data['exclude_post'];
  $author_post= $setting_data['author_post'];
 }
 if($rss_filter_message = get_option('rss_filter_message') && !isset($_POST['update']))
 {
  $rss_filter_message1 = get_option('rss_filter_message');
  echo' <div class="updated_setting"><p>'.$rss_filter_message1.'</p></div>';
  update_option('rss_filter_message','');
 }

 echo'<link rel="stylesheet" type="text/css" href="'.$myCsseUrl.'">';

 echo'<div class="wrap">
      <div id="icon-generic" class="icon32 "></div>      
      <h2>RSS Filter</h2><br>
	  </div>	';
?>
 <p>RSS Filter plugin .You have option to customization your WordPress RSS feed.</p>

<?php
 echo'<form method="post"  width="90%" action="'.$action_url.'" ><h2 class="nav-tab-wrapper">&nbsp;
		<a href="#" class="nav-tab nav-tab-active">RSS Filter Setting</a>
		<a href="'.admin_url('admin.php?page=rss_filter_help').'" class="nav-tab">Help</a>
      </h2><br><br>
      <div>
	  <table border="0"   width="95%" cellspacing="2"  cellpadding="3" >
	   <tr>
		<td><input type="checkbox" name="show_sticky"  value="yes"'.(($show_sticky=='yes')?'checked':'').' id="show_sticky"> &nbsp;&nbsp;
		    <label for="show_sticky" class="rssFilter_setting_title">Show Only Sticky Post</label><br><span class="rssFilter_setting_desc">In feed Only show sticky post .</span></td>
	   </tr>
	   <tr>
		<td class="rssFilter_setting_title">Exclude Category</td>
	   </tr>
	   <tr>
		<td><input type="text" name="exclude_category"  value="'.$exclude_category.'" id="exclude_category" class="rssFilter_setting_input"><br><span class="rssFilter_setting_desc">Enter a comma seperated category ID. ex : <code>2,3</code> &nbsp;&nbsp;(Display latest post except these categories).</span></td>
	   </tr>	   
	   <tr>
		<td class="rssFilter_setting_title">Exclude Post</td>
	   </tr>
	   <tr>
		<td><input type="text" name="exclude_post"  value="'.$exclude_post.'" id="exclude_post" class="rssFilter_setting_input"><br><span class="rssFilter_setting_desc">Enter a comma seperated Post ID\'s. ex : <code>4,5,11</code> &nbsp;&nbsp;(Display latest post except these post).</span></td>
	   </tr>
	   <tr>
		<td class="rssFilter_setting_title">Author  ID\'s</td>
	   </tr>
	   <tr>
		<td><input type="text" name="author_post"  value="'.$author_post.'" id="author_post" class="rssFilter_setting_input"><br><span class="rssFilter_setting_desc">Enter a comma seperated author  ID\'s. ex : <code>1,2</code> &nbsp;&nbsp;(Display only these authors post).</span></td>
	   </tr>
	  </table><p class="submit"><input type="submit" name="update"value="Update" class="button button-primary button-large"></p></form>
     </div>';
}
endif;

if (!function_exists('rss_filter_help')) :
function rss_filter_help()
{
 global $wpdb;
 $plugin_page= plugin_basename(__FILE__);
 $myCsseUrl = plugins_url('stylesheet.css', __FILE__);

 echo'<link rel="stylesheet" type="text/css" href="'.$myCsseUrl.'">';

 echo'<div class="wrap">
      <div id="icon-generic" class="icon32 "></div>      
      <h2>RSS Filter</h2><br>
	  </div>	';
?>
 <p>RSS Filter plugin .You have option to customization your WordPress RSS feed.</p>

<?php
 echo'<h2 class="nav-tab-wrapper">&nbsp;
		<a href="'.admin_url('admin.php?page='.$plugin_page).'" class="nav-tab">RSS Filter Setting</a>
		<a href="#" class="nav-tab nav-tab-active">Help</a>
      </h2><br><br>
      <div>
	    1. <b>Only Sticky Post show in rss feed?</b><br>
         <p>Show Only Sticky Post check box set to checked .if no sticky post found that it work default like</p><br>

	    2. <b>How to Exclude Certain Categories From RSS Feed?</b><br>
         <p>in Exclude Category text box enter category id (comma seperated )</p><br>

	    3. <b>How to Exclude Certain Post From RSS Feed?</b><br>
         <p>in Exclude Post text box enter post id (comma seperated)</p><br>

	    4. <b>How to given Author Post From RSS Feed?</b><br>
         <p>in Author  ID\'s enter author id (comma seperated)</p><br>

     </div>';
}
endif;

function myFeedExcluder($query) {
 if ($query->is_feed) {
  $data = json_decode(get_option('rss_filter_setting'));
  $setting_data = (array) json_decode(get_option('rss_filter_setting'));
  $exclude_category = explode(",",$setting_data['exclude_category']);
  $exclude_post = explode(",",$setting_data['exclude_post']);
  $author_post = ($setting_data['author_post']!='')?explode(",",$setting_data['author_post']):'';  
  $show_sticky = $setting_data['show_sticky'];

   if(count($exclude_category)>0)
   $query->set('category__not_in',$exclude_category);
   if(count($exclude_post)>0)
   $query->set('post__not_in',$exclude_post);
   if($show_sticky=='yes')
   $query->set('post__in',get_option( 'sticky_posts' ));
   if($author_post!='' &&  count($author_post)>0)
   $query->set('author__in',$author_post);
   //print_r($query);die();
 }
return $query;
}
add_filter('pre_get_posts','myFeedExcluder');

register_deactivation_hook(__FILE__, 'rss_filter_deactivate');
register_activation_hook(__FILE__, 'rss_filter_activate');

if (!function_exists('rss_filter_deactivate')) :
function rss_filter_deactivate()
{
 delete_option('rss_filter_setting');
}
endif;
if (!function_exists('rss_filter_activate')) :
function rss_filter_activate()
{
 $rss_filter_setting =array('show_sticky'=>'','exclude_category'=>'','exclude_post'=>'','author_post'=>'');
 $data=json_encode($rss_filter_setting);
 update_option('rss_filter_setting',$data); 
}
endif;
?>