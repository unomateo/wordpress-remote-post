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

$array = array();
if($_POST['parent_id']){
    $array['parent'] = $_POST['parent_id'];
}

$res = wp_insert_term( $_POST['category_name'], 'category', $array);
echo json_encode($res);
