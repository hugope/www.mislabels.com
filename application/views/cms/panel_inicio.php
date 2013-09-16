<div id="content" class="container-fluid">
	<div class="page-header">
		<h1>Dashboard <small>Informaci&oacute;n general del sitio.</small></h1>
	</div>
	<div class="row-fluid">
		<div class="span7 widget">
			<h6 class="title">Dashboard</h6>
			<table class="table table-striped table-bordered table-hover">
				<tbody>
					<?php foreach($dashboard as $key => $data):?>
					<tr>
						<td><strong><?php echo $nomenclatura[$key]?></strong></td>
						<td><?php echo $data?></td>
					</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
		
		<div class="span5 widget">
            <h6 class="title">&iquest;Necesita Asistencia?</h6>
            <p>Si necesita asistencia en el manejo de este sistema de administración, puede contactarnos por medio de este formulario.</p>
                <form class="form-horizontal" method="post" action="<?php echo $this->config->site_url('cms/plugin_posts/assistance_request_post/')?>">
    				<div class="control-group <?php echo $this->session->flashdata('alert_inputName')?>">
    					<label class="control-label" for="inputEmail">Nombre</label>
    					<div class="controls">
    						<input type="text" name="inputName" id="inputName" placeholder="Nombre" value="<?php echo $this->session->flashdata('data_inputName'); ?>">
							<?php echo $this->session->flashdata('error_inputName')?>
    					</div>
    				</div>
    				<div class="control-group <?php echo $this->session->flashdata('alert_inputEmail')?>">
    					<label class="control-label" for="inputEmail">Email</label>
    					<div class="controls">
    						<input type="text" id="inpuEmail" name="inputEmail" placeholder="Email" value="<?php echo $this->session->flashdata('data_inputEmail'); ?>">
							<?php echo $this->session->flashdata('error_inputEmail')?>
    					</div>
    				</div>
    				<div class="control-group <?php echo $this->session->flashdata('alert_inputMessage')?>">
    					<label class="control-label" for="inputMessage">Mensaje</label>
    					<div class="controls">
    						<textarea type="text" id="inputMessage" name="inputMessage" placeholder="Mensaje"><?php echo $this->session->flashdata('data_inputMessage'); ?></textarea>
							<?php echo $this->session->flashdata('error_inputMessage')?>
    					</div>
    				</div>
   				    <div class="form-actions">
					    <button type="submit" class="btn btn-primary">Enviar duda</button>
				    </div>
    			</form>
        </div>
	</div>

	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Día', 'Visitas'],
          
          <?php 
          foreach($analyticsResponse['DATA'] as $i => $visits):
			$day 	= ($i + 1);
			$visits	= (empty($visits))?'0':$visits;
			$date	= date('Y-m-').$day;
			$coma 	= ($date === date('Y-m-d'))?'':',';
          	?>
          ['<?=$day?>',  <?=$visits?>]<?=$coma?>
          <?php endforeach;?>
        ]);

        var options = {
        	<?php $month = array(NULL, 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');?>
          	title: 'Visitas en el mes de <?php echo $month[date('n')]?> [<?=array_sum($analyticsResponse['DATA'])?>]',
		    vAxis: {title: "Visitas"},
		    hAxis: {title: "Día de <?php echo $month[date('n')]?>"}

        };

        var chart = new google.visualization.LineChart(document.getElementById('line_chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div class="row-fluid">
		<div class="span4">
			<div class="row-fluid">
				<div class="span12 widget">
					<h6 class="title">Accesos Google Analytics</h6>
					<?php if(!empty($analytics)):?>
					<dl class="dl-horizontal">
						<dt>Acceso</dt>
						<dd>&raquo; <a target="_blank" href="<?php echo $analytics->ANALYTICS_URL?>"><?php echo $analytics->ANALYTICS_URL?></a></dd>
						
						<dt>Usuario</dt>
						<dd>&raquo; <?php echo $analytics->ANALYTICS_USER?></dd>
						
						<dt>Contrase&ntilde;a</dt>
						<dd>&raquo; <?php echo $analytics->ANALYTICS_PASSWORD?></dd>
					</dl>
					<?php endif;?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12 widget">
					<h6 class="title">Documentaci&oacute;n</h6>
					<table class="table table-hover">
						<tr>
							<td><strong>Gu&iacute;a de uso</strong></td>
							<td><a href="" class="btn btn-block btn-primary">Descargar <i class="icon-download icon-white"></i></a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="span8 widget">
			<h6 class="title">Gr&aacute;fico de visitas</h6>
			<?php if($google_api_connect === ''):?>
				<?php if(isset($analyticsResponse) && $analyticsResponse['ERROR'] === FALSE):?>
				<table class="table table-bordered">
					<tr>
						<td>
							<div id="line_chart_div" style="height: 330px;"></div></td></tr></table>
				<?php else:?>
				<div class="alert alert-danger alert-block">
					<h4>Error en la conexión con Analytics</h4>
					<strong>Se obtuvo el siguiente error al tratar de conectar: </strong><?php echo $analyticsResponse['ERROR']?></div>
				<?php endif;?>
			<?php else:?>
				<p>Permite el acceso a la cuenta de Google Analytics para desplegar los datos desde este panel de control. <br>
				Puedes ingresar desde aqu&iacute; presionando el siguiente bot&oacute;n: </p>
				<p><?php echo $google_api_connect;?></p>
			<?php endif;?>
		</div>
	</div>
</div>