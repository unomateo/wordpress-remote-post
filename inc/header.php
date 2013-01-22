<style>
	.cat_row
	{
	border-radius:5px;
	border:1px solid #cccccc;
	padding:5px;
	background-color:#f2f2f2;
	margin-bottom:5px;
	}
	
	.errorgbn
	{
	background-color:#ffaaaa;
	}
	
	.activegbn
	{
	background-color:#d4ffaa;
	}
	
	.row
{
	margin-top:10px;
	padding:3px;
	border-radius:3px;
	font-weight:bold;
}

.green
{
	border:1px solid #aaff56;
	background-color:#d4ffaa;
}

#ddcolortabs{
margin-left: 4px;
padding: 0;
width: 100%;
background: transparent;
voice-family: "\"}\"";
voice-family: inherit;
padding-left: 5px;
}

#ddcolortabs ul{
font: bold 11px Arial, Verdana, sans-serif;
margin:0;
padding:0;
list-style:none;
}

#ddcolortabs li{
display:inline;
margin:0 2px 0 0;
padding:0;
text-transform:uppercase;
}


#ddcolortabs a{
float:left;
color: white;
background: #6f9cf7 url(media/color_tabs_left.gif) no-repeat left top;
margin:0 2px 0 0;
padding:0 0 1px 3px;
text-decoration:none;
letter-spacing: 1px;
}

#ddcolortabs a span{
float:left;
display:block;
background: transparent url(media/color_tabs_right.gif) no-repeat right top;
padding:4px 9px 2px 6px;
}

#ddcolortabs a span{
float:none;
}


#ddcolortabs a:hover{
background-color: #4a6db2;
}

#ddcolortabs a:hover span{
background-color: #4a6db2;
}

#ddcolortabs #current a, #ddcolortabs #current span{ /*currently selected tab*/
background-color: #4a6db2;
}

#ddcolortabsline{
clear: both;
padding: 0;
width: 100%;
height: 8px;
line-height: 8px;
background: #6f9cf7;
border-top: 1px solid #fff; /*Remove this to remove border between bar and tabs*/
}
	
</style>
<script>
	$(document).ready(function (){
	
	$('#delete_token').click(function(){
		if(confirm('Are you sure?')){
		
			$.ajax({
			  url: "<?= WP_PLUGIN_URL."/".plugin_basename('guestblognetwork')?>/inc/delete_token.php",
			  type:"GET",
			  async:true,
			  success: function(d){
			    
			  		top.location.reload();
			  	
			  },
			  dataType:'json',
			  
			});
			
		}
		else
		{
			alert('cancel');
		}
	})
	
  	$('#cat_update').click(function (){
  		$.ajax({
		  url: "<?= WP_PLUGIN_URL."/".plugin_basename('guestblognetwork')?>/inc/update_category.php?type=add&local_cat="+$('#local_cat').val()+"&remote_cat="+$('#cat').val(),
		  type:"GET",
		  async:true,
		  success: function(d){
		    if(d.status=='success')
		  	{
		  		top.location.reload();
		  	}
		  	else
		  	{
		  		alert(d.status);
		  	}
		  },
		  dataType:'json',
		  
		});
  	});
  	
  	$('.delete_connection').click(function (){
  	var mysplit = $(this).attr('id').split("|");
  	var l = mysplit[0];
  	var r = mysplit[1];
  	$
  		$.ajax({
		  url: "<?= WP_PLUGIN_URL."/".plugin_basename('guestblognetwork')?>/inc/update_category.php?type=delete&local_cat="+l+"&remote_cat="+r,
		  type:"GET",
		  async:true,
		  success: function(d){
		    if(d.status=='success')
		  	{
		  		top.location.reload();
		  	}
		  	else
		  	{
		  		alert(d.status);
		  	}
		  },
		  dataType:'json',
		  
		});
  	});
  	
  	//$('#result').load('<?= WP_PLUGIN_URL."/".plugin_basename('guestblognetwork')?>/inc/categories.php');
  });
</script>
<?php
//include('common.php');

	$items['guestblognetwork/guestblognetwork.php'] = array('text'=>'Dashboard', 'stage'=>'', 'page'=>'guestblognetwork/guestblognetwork.php');
	//$items['articles'] = array('text'=>'Manage Articles', 'stage'=>'', 'page'=>'articles');
	//$items['websites'] = array('text'=>'Manage Websites', 'stage'=>'', 'page'=>'websites');
	$items['categories'] = array('text'=>'Map Categories', 'stage'=>'', 'page'=>'categories');
	$items['help'] = array('text'=>'Help', 'stage'=>'', 'page'=>'help');
	
	$sub['the_gbn/gbn.php'][] = array();
	
	//$items['articles']['subs']['list'] = array('text'=>'Write Article', 'stage'=>'spin');
	//$items['websites']['subs']['add'] = array('text'=>'Add Website', 'stage'=>'add');
	//$items['websites']['subs']['park'] = array('text'=>'Park Domains', 'stage'=>'park');
	//$items['websites']['subs']['list'] = array('text'=>'List Websites', 'stage'=>'list');
	
	//$items['articles']['subs']['add'] = array('text'=>'New article', 'stage'=>'add_article');
	//$items['articles']['subs']['list'] = array('text'=>'View Articles', 'stage'=>'list');
	//$items['websites']['subs']['list'] = array('text'=>'List Websites', 'stage'=>'list');

	$menu = $items;
	
function authorizeURL()    { return 'http://guestblognet.com/authorize.php?d='.$_SERVER['HTTP_HOST']; }
function requestTokenURL() { return 'http://guestblognet.com/api/request_token.php?d='.$_SERVER['HTTP_HOST']; }
function get_callback(){return PLUGINURL."/inc/store_tokens.php";}
?>

<div style='float:left'><h2>GBN LOGO</h2></div>
<div style='float:right; width:400px'>
	<?
	if(!get_option('gbn_access_token')): ?>
	<?$redirect =  WP_PLUGIN_URL."/".plugin_basename('guestblognetwork')."/get_tokens.php" ?>
	<div class='row red'><div class='inner_pad'> You are not connected to the Guest Blog Network. <input type='button' onClick="PopupCenter('<?= requestTokenURL()?>&callback=<?= get_callback()?>', 'Connect to the GBN',500,300);"  value='Connect this blog to the GBN' /></div></div>
	<? else: ?>
	<div class='row green'><div class='inner_pad'><img style='width:25px;' src='<?= WP_PLUGIN_URL."/".plugin_basename('guestblognetwork')?>/images/lock.png' align='absmiddle' /> You are connected to the Guest Blog Network <a id='delete_token' href='javascript:;'>Delete</a></div></div>
	<? endif ?> 
</div>
<br style='clear:both'>
<div class="blue">
	<div id="ddcolortabs">
		<ul>
			<?php foreach ($menu as $key => $value): 
			$current = ($_GET['page']==$value['page'])?"class='current'":"";
				?>
				<li><a href="?page=<?= $value['page']?>" title="<?= $value['text']?>" <?= $current?>><span><?= $value['text']?></span></a></li>
			<?php endforeach ?>
		</ul>
	</div>
	<div id="ddcolortabsline">&nbsp;</div>
	<div style='padding:3px;background-color:#b6daea;'>
		<?php if ($menu[$_GET['page']]['subs'] ): ?>
		<ul class='submenu'>
		<?php foreach ($menu[$_GET['page']]['subs'] as $key => $value): ?>
			<li><a href="?page=<?= $_GET['page']?>&stage=<?= $value['stage']?>"><?= $value['text']?></a></li>
		<?php endforeach ?>
		</ul>
		<?php endif ?>
	</div>
</div>
