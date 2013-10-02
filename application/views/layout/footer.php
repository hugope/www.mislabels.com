		<div id="footer_wrapper">
			<div class="footerContener" id="footer_cat_nav">
				<div class="footer_topnav">
					<ul class="slider slider-footer">
						<?php foreach($categories_menu as $cat): ?>
						<?php $selected = ($cat->ACTIVE)?'checked="checked"':'';?>
						<li><a categoryfilter="categoryfilter_<?php echo $cat->ID?>" data-cat="<?php echo $cat->ID?>" class="categorybtnfilter" href="#" style="background-color:<?php echo $cat->CATEGORY_COLOR?>;"><?php echo $cat->CATEGORY_NAME?></a></li>
						<?php endforeach?>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="footerBottonBox">
					<div class="footerLeft_bottomnav">
						<ul>
							<?php foreach($menu_btns as $btn): $active = ($current_page == strtolower($btn->CLASS))?'active':'';?>
							<li><a href="<?php echo site_url(strtolower($btn->CLASS).'/')?>" class="<?php echo $active?>"><?php echo $btn->LABEL?></a></li>
							<?php endforeach?>
						</ul>
						<div class="clr"></div>
					</div>

					<div class="footerRight_bottomnav">
						<ul>
							<li><a href="<?php echo site_url('miperfil')?>">Mi Cuenta</a></li>
							<li><a href="<?php echo site_url('carrito')?>">Mi Carrito</a></li>
						</ul>
						<div class="clr"></div>
					</div>
					<div class="clr"></div>
				</div>
				<div class="footerBotton_EndedBox">
					<div class="copyright"><p>&copy;2013. Mis Labels. Reservados Todos los derechos. <span>Desarrollado por</span> <a href="http://www.grupoperinola.com/" target="_blank">Perinola</a></p></div>
					<div class="footerLogo"><a href="<?php echo site_url()?>"><img src="<?php echo base_url('library/images/footer_logo.png')?>" alt="Logo" /></a></div>
					<div class="socialConnect">
						<ul>
							<li  class=""><a href="#"><img src="<?php echo base_url('library/images/newletter.png')?>" alt="Newsletter" /><br />Newsletter</a></li>
							<li><a href="<?php echo $this->fw_content->single_post('facebook')?>"><img src="<?php echo base_url('library/images/facebook.png')?>" alt="Facebook" /><br />Facebook</a></li>
							<li><a href="<?php echo $this->fw_content->single_post('youtube')?>"><img src="<?php echo base_url('library/images/youtube.png')?>" alt="YouTube" /><br />Youtube</a></li>
						</ul>
						<div class="clr"></div>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>
		<!-- catalog form helper -->
		<form action="<?php echo site_url('etiquetas/index')?>" method="POST" id="catalog_filter" class="catalog-form" >
			<input type="hidden" name="labels_categories[]" class="category" value="" />
		</form>
		<script src="<?php echo base_url('/library/js/tweets.js') ?>"></script>
		<script src="<?php echo base_url('/library/js/jquery.scrollTo-1.4.3.1-min.js') ?>"></script>
		<script src="<?php echo base_url('/library/js/jquery.bxslider.min.js') ?>"></script>
		<script src="<?php echo base_url('/library/js/main.js') ?>"></script>
	</body>
</html>
