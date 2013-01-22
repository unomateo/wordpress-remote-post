<?php

class GBN_Client
{
	var $auth_server;
	var $consumer_key = 'gbn_default';
	var $consumer_secret = 'gbn_default_secret';
	var $access_token = '';
	var $access_token_secret = '';
	
	function __construct()
	{	
		//$this->auth_server = new OAuthServer(new gbn_datastore());
	}
	
	function set_consumer($consumer_key, $consumer_secret)
	{
		$this->consumer_key = $consumer_key;
		$this->consumer_secret = $consumer_secret;
	}
	
	function set_access_token($access_token, $access_token_secret)
	{
		$this->access_token = $access_token;
		$this->access_token_secret = $access_token_secret;
	}
	
	function do_request($url, $method = 'POST', $parameters = '')
	{
		$consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret, NULL);
		$token = new OAuthConsumer($this->access_token, $this->access_token_secret, 1);
		$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();
		$parameters['domain'] = $_SERVER['HTTP_HOST'];
		$req = OAuthRequest::from_consumer_and_token($consumer, $token, $method, $url);
		$req->sign_request($hmac_method, $consumer, $token);
		$signedurl = $req->to_url();
		$header = $req->to_header();
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST,count($parameters));
		curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array($header));
		$data = curl_exec($ch);
		//die($data);
		curl_close($ch);
		return $data;

	}
	
	function get_categories()
	{
		$res = $this->do_request("http://guestblognet.com/index.php/services/get_categories");
		return $res;
	}
}

class GBN_Server
{
	var $auth_server;
	var $consumer_key = 'gbn_default';
	var $consumer_secret = 'gbn_default_secret';
	var $access_token = '';
	var $access_token_secret = '';
	
	function __construct()
	{	
		//$this->auth_server = new OAuthServer(new gbn_datastore());
	}
	
	
}


