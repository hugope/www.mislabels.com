<div id="content" class="container-fluid">
	<div class="page-header">
		<h1> <?php echo $page_title; ?><small></small></h1>
	</div>
	<div class="row-fluid">
		<div class="span12 well">
			<div class="row-fluid">
				<div class="span12">
					<form class="form-inline">
						<label for="reports_month">Mes de</label> <?php echo form_dropdown('reports_month', $componentes_fecha['meses'], $month, 'id="reports_month" onchange="change_date_filter()"');?>
						<label for="reports_year"> del a&ntilde;o</label> <?php echo form_dropdown('reports_year', $componentes_fecha['aAnteriores'], $year, 'id="reports_year" onchange="change_date_filter()"')?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Reporte</th>
						<th>Descargar Completo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($reportes as $id => $reporte):?>
						<tr>
							<td class="span9"><?php echo $reporte?></td>
							<td class="span1"><input type="checkbox" class="display_all"></td>
							<td class="span2"><a class="btn btn-success" typeid="<?php echo $id?>" href="<?php echo base_url('cms/plugin_reportes/download_excel/'.$segment.'/'.$id)?>" target="_blank">Descargar <i class="icon-download icon-white"></i></a></td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function change_date_filter(){
		var month 	= $('select#reports_month').val();
		var year	= $('select#reports_year').val();
		
		location.href = "<?php echo base_url('cms/plugin_reportes/index')?>/"+month+"-"+year;
	}
	$(function(){
		$('input.display_all').click(function(){
			var downloadbtn = $(this).parent().parent().find('a.btn');
			var typeid		= downloadbtn.attr('typeid');
			if($(this).is(':checked')){
				downloadbtn.attr('href', '<?php echo base_url('cms/plugin_reportes/download_excel/COMPLETE')?>/'+typeid);
			}else{
				downloadbtn.attr('href', '<?php echo base_url('cms/plugin_reportes/download_excel/'.$segment)?>/'+typeid);
			}
		});
	});
</script>