<?php
include($_SERVER["DOCUMENT_ROOT"]."/wp-config.php");

$gbn = new GBN_Client();

//set access token
$access_token = get_option('gbn_access_token');
$access_token_secret = get_option('gbn_access_token_secret');
$gbn->set_access_token($access_token, $access_token_secret);
		
$parameters = $_GET;
if($_GET['type']=='add')
echo $gbn->do_request('http://guestblognet.com/index.php/services/update_category', 'POST',$parameters);
else
echo $gbn->do_request('http://guestblognet.com/index.php/services/delete_category', 'POST', $parameters);
