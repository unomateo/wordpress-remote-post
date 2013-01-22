<?php
include($_SERVER["DOCUMENT_ROOT"]."/wp-config.php");

$gbn = new GBN_Client();

//set access token
$access_token = get_option('gbn_access_token');
$access_token_secret = get_option('gbn_access_token_secret');
$gbn->set_access_token($access_token, $access_token_secret);
		
$data = json_decode($gbn->do_request('http://guestblognet.com/index.php/services/get_categories/'.$_POST['parent'])); 
foreach($data->cats as $key=>$value)
{
	$str .= "<option value='".$key."'> ".$value->cat_name."</option>";
}
echo $str;
