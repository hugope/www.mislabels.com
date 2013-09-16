<div id="content" class="container-fluid">
	<div class="page-header">
		<h1> <?php echo $page_title; ?><small></small></h1>
	</div>
	<div class="row-fluid">
		<div class="span12 well">
			<div class="row-fluid">
				<div class="span8">
					<?php if($this->display_filter == 'SEARCH'):?>
					<form class="form-search" style="float:right;" method="POST" action="<?php echo $this->config->site_url('cms/'.strtolower($this->current_plugin).'/search_filter_redirect')?>">
						<input type="text" class="input-medium search-query" name="SEARCH">
						<button type="submit" class="btn">Search</button>
					</form>
					<?php endif;
					if($this->display_filter == 'LIST'):
						$js = 'id="LISTFILTER" onChange="listfilter_function();"';
						echo form_dropdown('LISTFILTER', $filteroptions,$filter,$js);
					endif;?>
				</div>
				<div class="span4">
					<?php echo $pagination;?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<?php foreach($header as $i => $th):?>
						<?php if($i > 0):?>
						<th><?=$th?></th>
						<?php endif; endforeach?>
					</tr>
				</thead>
				<tbody>
					<?php echo $body?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function listfilter_function(){
		var filter = $('select#LISTFILTER').val();
		
		location.href = '<?php echo $this->config->site_url('cms/'.strtolower($this->current_plugin).'/index')?>/'+filter;
	}
</script>