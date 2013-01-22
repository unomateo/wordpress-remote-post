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
 
 $args = array(
    'show_option_all'    => '',
    'show_option_none'   => ' ',
    'orderby'            => 'ID', 
    'order'              => 'ASC',
    'show_count'         => 0,
    'hide_empty'         => 0, 
    'child_of'           => 0,
    'exclude'            => '',
    'echo'               => 1,
    'selected'           => 0,
    'hierarchical'       => 1, 
    'name'               => 'cat',
    'id'                 => 'cat_drop',
    'class'              => 'catselect',
    'depth'              => 0,
    'tab_index'          => 0,
    'taxonomy'           => 'category',
    'hide_if_empty'      => false );

wp_dropdown_categories($args);