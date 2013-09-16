
<div class="clr"></div>
</div></div>

<div class="bodyContent">
<div class="wrapper_profilebody">
<div class="about_banner"><img src="<?php echo $this->fw_content->imgsrc('about_banner1.jpg')?>" alt="Banner" /></div>
<div class="about_whitebox">
<div class="aboutLeft_content">
<h3><?php echo $this->fw_content->single_post('nosotros', TRUE)?></h3>
<p><?php echo $this->fw_content->single_post('nosotros')?></p>
</div>
<div class="aboutRegister">
<p><strong>&iquest;Ya tienes cuenta con nosotros?</strong></p>
<p><a href="<?php echo site_url('login')?>"><img src="<?php echo base_url('library/images/about_register.jpg')?>" alt="Register" /></a></p>
</div>
<div class="clr"></div>
	<div class="about_locationbox">
		<h3>Ubicaciones</h3>
		<ul>
			<?php 
			foreach($locations as $location):
			$mapdata = explode(',', $location->SHIPPING_MAP)?>
			<li>
				<h3><?php echo $location->SHIPPING_TITLE?></h3>
				<div class="map-display" data-lat="<?=$mapdata[0]?>" data-lon="<?=$mapdata[1]?>"></div>
				<p><img src="<?php echo base_url('library/images/location_img.jpg')?>" alt="Location" /> <?php echo $location->SHIPPING_ADDRESS?></p>
				<p><img src="<?php echo base_url('library/images/Location_phone.jpg')?>" alt="Location" /> <?php echo $location->SHIPPING_TEL?></p>
			</li>
			<?php endforeach?>
		</ul>
		<div class="clr"></div>
	</div>
</div>
</div></div></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX5T1cFH_Z5s-YNLEGXnSntm4pYldJccI&sensor=false"></script>
<script src="<?php echo base_url('library/js/script.printmap.js')?>"></script>