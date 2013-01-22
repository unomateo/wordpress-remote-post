<?php
include('../../../../wp-config.php');

update_option('gbn_access_token', $_GET['access_token']);
update_option('gbn_access_token_secret', $_GET['access_token_secret']);

echo get_option('gbn_access_token');
