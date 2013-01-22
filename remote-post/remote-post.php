<?php

/*
Plugin Name: The GuestBlogNetwork 2
Plugin URI: http://guestblognetwork.com
Description: Publish your blog posts into the GBN and also consume posts written by others
Version: 2.0
License: GPL
Author: Matt Dunlap
Author URI: http://guestblognetwork.com
Contributors:
 ==============================================================================
*/
include('lib/gbn.class.php');

define(PLUGINPATH, WP_PLUGIN_DIR."/".plugin_basename('guestblognetwork'));
define(PLUGINURL, WP_PLUGIN_URL."/".plugin_basename('guestblognetwork'));
include(PLUGINPATH."/lib/oauth.php");
include(PLUGINPATH."/lib/view.class.php");
include(PLUGINPATH."/lib/gbn_oauth_datastore.php");


class GBN extends GBN_Client
{
	var $view; 
	
	function __construct()
	{
		parent::__construct();
		
		//set access token
		$access_token = get_option('gbn_access_token');
		$access_token_secret = get_option('gbn_access_token_secret');
		$this->set_access_token($access_token, $access_token_secret);
		
		//hook up with Wordpress and make sweet love...
		add_action('admin_menu', array(&$this,'the_gbn_menu'));
		add_action('admin_head', array(&$this,'gbn_styles'));
		$this->view = new View();
	}
	
	function the_gbn_menu()
	{
		add_menu_page('Guest blog Network', 'Guest Blog Net', 0, __FILE__, array(&$this,'gbn_load_admin'));
	  	add_submenu_page(__FILE__, 'GBN', 'Map Categories', 0, 'categories', array(&$this, 'categories'));
		add_submenu_page(__FILE__, 'GBN', 'Write Articles', 0, 'articles', 'articles');
		add_submenu_page(__FILE__, 'GBN', 'Manage Websites', 0, 'websites', 'websites');
		add_submenu_page(__FILE__, 'GBN', 'Help', 0, 'help', 'help');
	}
	
	function gbn_styles()
	{
		?>
		<link rel='stylesheet' href='<?= get_bloginfo('wpurl')?>/wp-content/plugins/the_gbn/css/style.css' type='text/css' media='all' /> 
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
		<script>
		  function PopupCenter(pageURL, title,w,h) {
		  var left = (window.screen.width/2)-(w/2);
		  var top = (screen.availHeight/2)-(h/2);
		  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
		  } 
		  </script>
		<?
		wp_tiny_mce();
	}
		
	function gbn_load_admin()
	{
	
		include('inc/header.php');
	}
	
	function categories($parent='')
	{
		$data = json_decode($this->do_request('http://guestblognet.com/index.php/services/get_categories/'.$parent));
        //print_r($data);
		?>
		<div class='wrap'>
	  	<? include('inc/header.php');
		$this->view->display_categories($data);
		?>
		</div>	
		<?
	}
	
}

$gbn = new GBN();
