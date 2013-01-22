<?php

class gbn_datastore extends OAuthDataStore
{
	  function __construct()
	  {
	    
	  }
	  
	  function lookup_consumer($consumer_key) {
	    $consumer = new OAuthConsumer("gbn_default", "gbn_default_secret", NULL);
	    return $consumer;
	  }
	
	  function lookup_token($consumer, $token_type, $token) {
	    $token = new OAuthToken(get_option('gbn_access_token'), get_option('gbn_access_token_secret'));
	    return $token;
	  }
	
	  
	 // function get_access_token($domain_name, $request_token, $user_id)
	 // {
	//	$array['gbn_in_request_token'] = get_option('gbn_in_request_token');
	//	$array['gbn_in_request_token_secret'] = get_option('gbn_in_request_token_secret');
	//	return $array;
	 // }

}