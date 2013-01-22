<?php
global $cats;
$cats =  file_get_contents('http://guestblognet.com/services/get_main_categories/');
$cats = json_decode($cats);
echo "Remote: <select id='remote_cat' name='parent_cat'>";
foreach($cats as $c)
{
	if($c->parent_id==0)
	{
	?>
	<option value='<?= $c->ID?>'> <?= $c->cat_name?>
	<?
	}
}
echo "</select>";
