<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/wp-config.php");
define(PLUGINPATH, WP_PLUGIN_DIR."/".plugin_basename('guestblognetwork'));
define(PLUGINURL, WP_PLUGIN_URL."/".plugin_basename('guestblognetwork'));
require_once(PLUGINPATH."/lib/gbn.class.php");
require_once(PLUGINPATH."/lib/oauth.php");
require_once(PLUGINPATH."/lib/gbn_oauth_datastore.php");

$consumer_key='gbn_default';
$consumer_secret = 'gbn_default_secret';
$access_token = get_option('gbn_access_token');
$access_token_secret = get_option('gbn_access_token_secret');

$consumer = new OAuthConsumer($consumer_key, $consumer_secret, NULL);
$token = new OAuthConsumer($access_token, $access_token_secret, 1);


//get the oauth server ready for accepting calls from the GBN
//$server = new OAuthServer(new gbn_datastore());
//$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();

//endpoints
function authorizeURL()    { return 'http://guestblognet.com/authorize.php?d='.$_SERVER['HTTP_HOST']; }
function requestTokenURL() { return 'http://guestblognet.com/api/request_token.php?d='.$_SERVER['HTTP_HOST']; }
function get_callback(){return PLUGINURL."/inc/store_tokens.php";}

//we only use HMAC
