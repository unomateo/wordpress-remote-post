<?php

//echo json_encode(array('status'=>'fail', 'error'=>"sadsadasd"));
include($_SERVER["DOCUMENT_ROOT"]."/wp-config.php");
define(PLUGINPATH, WP_PLUGIN_DIR."/".plugin_basename('guestblognetwork'));
include(PLUGINPATH."/lib/common.php");

$server = new OAuthServer(new gbn_datastore());
$server->add_signature_method(new OAuthSignatureMethod_HMAC_SHA1());

try
{
  $req = OAuthRequest::from_request();
  $server->verify_request($req);
}
catch(OAuthException $e)
{
  echo json_encode(array('status'=>'fail', 'error'=>$e->getMessage()));
  die;
}

//all good
// TODO: Possible problem if another user already has this username on a remote blog
// Create usermeta that checks to see if the user is a memeber of GBN
$user_id = username_exists( $_POST['username'] );
if(!$user_id)
{
	
	$user_id = wp_create_user($_POST['username'], $_POST['password'], $_POST['email'] );
	if(is_numeric($user_id))
	{
		$cap['contributor'] = 1;
		update_user_meta($user_id, $table_prefix."capabilities", $cap);
		update_user_meta($user_id, 'facebook_url', $_POST['facebook_url']);
		update_user_meta($user_id, 'twitter_url', $_POST['twitter_url']);
		update_user_meta($user_id, 'first_name', $_POST['last_name']);
		update_user_meta($user_id, 'last_name', $_POST['first_name']);
		update_user_meta($user_id, 'description', $_POST['bio_text']);
		update_user_meta($user_id, 'user_url', $_POST['user_url']);
	}
	else
	{
		foreach ($user_id->errors as $key => $value) {
			$str .= $value[0].", ";
		}
		echo json_encode(array('status'=>'fail', 'message'=>rtrim($str, ",")));
		die;
	}
	
}

$image_search = stripslashes($_POST['body']);
$title = $_POST['title'];

$upload_dir = wp_upload_dir();
$rand = md5(rand(0,1000).date('Y-m-d H:i:s'));
$pattern = '/<img[^>]+src[\\s=\'"]+([^"\'>\\s]+)/is';
$res = preg_match($pattern, $image_search, $matches);
//print_r($matches);
$image = file_get_contents($matches[1]);
file_put_contents($upload_dir['path'].'/'.$rand.'.jpg',$image);


//die;
$term = get_term_by('id', $_POST['category'] ,'category');

$_P['post_type'] = 'post';
$_P['post_content'] = $_POST['body'];
$_P['post_title'] = $title;
$_P['post_status'] = 'publish';
$_P['post_author'] = $user_id;
//updated category to accept int
$_P['post_category'] = array($term->term_id);
//$_P['post_category'] = 704;
unset($_POST);
$post_ID = wp_insert_post($_P);


if($post_ID)
{
	
	$filename = $upload_dir['path'].'/'.$rand.'.jpg';
	$wp_filetype = wp_check_filetype(basename($filename), null );
  	$attachment = array(
     'post_mime_type' => $wp_filetype['type'],
     'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
     'post_content' => '',
     'post_status' => 'inherit'
  	);
  	$attach_id = wp_insert_attachment( $attachment, $filename, $post_ID );
  // you must first include the image.php file
  // for the function wp_generate_attachment_metadata() to work
  	require_once(ABSPATH . 'wp-admin/includes/image.php');
  	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
  	wp_update_attachment_metadata( $attach_id, $attach_data );
	//wp_set_post_terms( $post_id, 'short sale, real estate, selling');
	
	wp_publish_post($post_ID);
	$post = get_post($post_ID);
	$permalink = get_permalink($post_ID);
  	echo json_encode(array('status'=>'success', 'category'=>$term->term_id,'permalink'=>$permalink, 'post_id'=>$post_ID, 'message'=>'Post Success', 'user_id'=>$user_id));
}
else
echo json_encode(array('status'=>'fail', 'message'=>'No Post ID'));
