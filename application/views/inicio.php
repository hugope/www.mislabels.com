
		<div class="bannerbox">
			<!-- MAIN CONTENT -->
      <div class="main-slider-content" id="showcase">
      	<div class="sliders-wrap-inner">
	        <ul class="slider slider-showcase">
	        	<?php foreach($slides as $slide):?>
	            <li><img src="<?php echo base_url('user_files/uploads/'.$slide->SLIDER_IMAGE)?>" /></li>
	          <?php endforeach?>
	        </ul>
      	</div>
      </div>
			<!-- END MAIN CONTENT -->
			<!-- NAVIGATOR -->
			<div class="navigator-content">
        <ul class="navigator-wrap-inner" id="showcase_pager">
					<?php foreach($slides as $key => $slide):?>
						<li>
							<a href="#" data-slide-index="<?php echo $key; ?>">
								<span class="elements-container">
									<span class="img-container">
										<img src="<?php echo base_url('user_files/uploads/'.$slide->SLIDER_IMAGE)?>">
									</span>
									<span class="content-container"><?php echo word_limiter($slide->SLIDER_DESCRIPTION, 10)?></span>
								</span>
							</a>
						</li>
					<?php endforeach?>
        </ul>
      </div>
		</div>


<div class="bodyContent">
	<div id="parent">
		<div class="portSliderbox">
			<h3>Lo m&aacute;s Nuevo</h3>
			<div id="newest">
				<div class="newset-container">
					<ul class="slider slider-newest">
						<?php foreach($latest as $new):?>
						<li><a href="<?php echo site_url('etiquetas/'.$new->STICKER_SET.'/'.$new->ID)?>" style="background-image: url(<?php echo base_url('user_files/uploads/'.$new->STICKER_GALLERY[0])?>);">#</a></li>
						<?php endforeach?>
					</ul>
				</div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="gallerybox">
			<h3>Lo m&aacute;s Popular</h3>
			<div id="popular_stickers">
				<?php foreach($populares as $popular):?>
				<a href="<?=site_url('etiquetas/'.$popular->STICKER_SET.'/'.$popular->ID)?>" style="background-image:url(<?=base_url('user_files/uploads/'.$popular->STICKER_GALLERY[0])?>)">#</a>
				<?php endforeach?>
			</div>
			<!--div class="gallerybox_button"><a href="#">Ver Populares</a></div -->
		</div>
		<div class="postbox">
			<h3>Art&iacute;culos Recientes</h3>
			<ul>
				<li>
					<a href="#"><img src="<?php echo base_url('library/images/post_img.jpg')?>" alt="IMG" /></a>
					<strong><a href="#">Lorem ipsum dolor </a></strong>
					<span>00-00-2013</span>
					<p>Lorem ipsum dolor sit amet, possit incorrupte in per, at pro eruditi partiendo...</p>
				</li>
				<li>
					<a href="#"><img src="<?php echo base_url('library/images/post_img1.jpg')?>" alt="IMG" /></a>
					<strong><a href="#">Lorem ipsum dolor </a></strong>
					<span>00-00-2013</span>
					<p>Lorem ipsum dolor sit amet, possit incorrupte in per, at pro eruditi partiendo...</p>
				</li>
				<li>
					<a href="#"><img src="<?php echo base_url('library/images/post_img.jpg')?>" alt="IMG" /></a>
					<strong><a href="#">Lorem ipsum dolor </a></strong>
					<span>00-00-2013</span>
					<p>Lorem ipsum dolor sit amet, possit incorrupte in per, at pro eruditi partiendo...</p>
				</li>
			</ul>
			<div class="gallerybox_button"><a href="#">Ver M&aacute;s</a></div>
		</div>
		<div class="clr"></div>
	</div>
</div>
