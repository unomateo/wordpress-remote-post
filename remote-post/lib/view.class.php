<?php

class View
{
	function __construct()
	{
		
	}
	
	function display_categories($data)
	{
		

			$local_cats = get_categories('hide_empty=0');
			foreach ($local_cats as $local) {
			$out[$local->term_id] = array('name'=>$local->name);
			}
			?>
			
			<script type="text/javascript">
			$(document).ready(function(){
			
			<?
			if($current_cat){
				?>
					$.ajax({
					   type: "POST",
					   url: "<?= base_url()?>account/articles/get_categories_ajax",
					   data: "id=<?= $current_cat[0]->p1?>",
					   success: function(data){
					    	$('#cat').html(data);
					    	Select_Value_Set('cat', <?= $current_cat[0]->child_id?>);
					   },
					   dataType: 'html'
					 });
					 
					
				<?
			}
			?>
			
				$('#remote_cat').change(function() {
			  		$.ajax({
					   type: "POST",
					   url: "<?= PLUGINURL?>/inc/get_remote_child.php",
					   data: "parent="+$(this).val(),
					   success: function(data){
					    	$('#cat').html(data);
					   },
					   dataType: 'html'
					 });
				});
			});
		</script>
			
			
			
			<div class='wrap'>
				<h2>Map Local categories to the network</h2>
				<div>When you map a local category to a network category, all posts received at the GBN will be syndicated to your webiste for that
					category.</div>
					<ol>
						<li>You can have more then one remote category mapped to a local category.</li>
						<li>You cannot have more then one of the same remote category mapped to a local category</li>
					</ol>
					
					<?php 
					foreach ($data->connections as $c): ?>
					<div class='cat_row <?= $c->status?>gbn'>
						<div style='float:left;width:250px;'><b>Local Category: </b>
							<?
							$l = $c->local_cat_id;
							echo $out[$l]['name'];
							?>
						</div>
						<div style='float:left;width:250px;'><b>Remote Category: </b>
							<?
							$r = $c->remote_cat_id;
							echo $data->cats->$r->cat_name;
							?>
						</div>
					    <div style='float:right'><input type='button' class='delete_connection' id='<?= $l?>|<?= $r ?>' value='Delete'></div>
					    <div style='clear:both'></div>
					</div>
					<?php endforeach ?>
					
					<div class='cat_row'>
						<div style='float:left;width:300px;'>Local Category: <? wp_dropdown_categories('id=local_cat&hide_empty=0')?></div> 
						<div style='float:left'>
							Remote Category: <select id='remote_cat' onSlect name='parent_cat'>
							<? foreach($data->cats as $key=>$value)
							{
								if($value->parent_id==0){
								?>
								<option value='<?= $key?>'> <?= $value->cat_name?>
								<?
								}
							} ?>
							</select>
							<select id='cat' name='category'>
            		
            				</select>
						</div>
					    <div style='float:left;width:100px;'><input type='button' id='cat_update' value='Map category'></div>
					    <div style='clear:left'></div>
					</div>
					
			</div>
		<?
              
                
	}
}
