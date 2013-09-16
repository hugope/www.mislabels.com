
<div class="clr"></div>
</div></div>

<div class="bodyContent">
	<div class="wrapperbody">
	<div class="regA1box">
		<div class="a1boxLeft">
			<h3>Label Set: <a href="javascript:void;" style="cursor:default;"><?php echo $sticker->STICKER_NAME?></a></h3>
			<p><span>Categor&iacute;a:</span><a href="#"> <?php echo $sticker->CATEGORY_NAME?></a> &nbsp;  &nbsp;  &nbsp; <span>Tipo:</span><a href="#"> <?php echo $sticker->LABEL?></a></p>
		</div>
		<div class="a1boxRight">
			<a class="personalizar" style="background-color: gray;background-image: url(<?php echo base_url('library/images/personalizar.png')?>);background-repeat: no-repeat;" href="#">
				regresar al cat&aacute;logo
			</a>
		</div>
		<div class="clr"></div>
	</div>
	<div class="labelSetleft">
		<form action="<?php echo $formaction?>" method="POST">
			<h3>Texto</h3>
			<p>Ingresa el texto que desea incluir en el dise&ntilde;o.</p>
			<div class="textoBox">
				<div class="refresh"><a href="#"><img src="<?php echo base_url('library/images/refresh.jpg')?>" alt="Refresh" /></a></div>
				<input type="text" onfocus="if(this.value=='<?php echo ascii_to_entities($texto)?>') this.value='';" onblur="if(this.value=='') this.value='<?php echo ascii_to_entities($texto)?>';" value="<?php echo ascii_to_entities($texto)?>" alt="<?php echo ascii_to_entities($texto)?>" name="STICKER_LABEL[]" id="sticker_label"/>
				<p><span>*El texto debe tener un m&aacute;ximo de 16 caracteres.</span></p>
			</div>
			<h3>Color</h3>
			<p>Selecciona un color del siguiente listado</p>
			<div class="colorChoose">
				<div class="paletaColores">
					<?php foreach($colors as $color):?>
					<a href="javascript:void(0)" style="background-color:<?php echo $color->COLOR_CODE?>" colorcode="<?php echo $color->COLOR_CODE?>" colorlabel="<?php echo $color->COLOR_LABEL?>" class="palette">#</a>
					<?php endforeach?>
					<input type="hidden" value="<?php echo $colorlabel?>" id="colorlabel" name="STICKER_COLOR" />
				</div>
			</div>

			<h3>Tipograf&iacute;a</h3>
			<p>Selecciona una tipograf&iacute;a para tu etiqueta</p>
				<?php foreach($fontfamilies as $fonts):?>
				<div class="chooseGrafia">
					<ul>
						<?php 
						foreach($fonts as $i => $font):
						$checked = ($i < 1)? 'checked="checked"':''?>
						<li><input name="stickerfontfamily" class="stickerfont" type="radio" value="<?php echo $font->FONT_LABEL?>" id="<?php echo $font->FONT_LABEL?>" <?=$checked?>  name="STICKER_FONT" fontfamily="<?php echo $font->FONT_FAMILY?>" /> <label style="font-family: '<?php echo $font->FONT_FAMILY?>'" for="<?php echo $font->FONT_LABEL?>"><?php echo $font->FONT_NAME?></a></li>
						<?php endforeach?>
					</ul>
				</div>
				<?php endforeach?>
			<div class="clr"></div>

			<div class="qtybox"><h3>Cantidad</h3>
				<input type="text" onfocus="if(this.value=='1') this.value='';" onblur="if(this.value=='') this.value='1';" value="1" alt="1" name="STICKER_QUANTITY"/>
				<span>set de 6 etiquetas</span>
			</div>

			<input type="hidden" name="STICKER_TYPE" value="<?php echo $this->uri->segment(3)?>" />
			<div class="greenbtn">
				<input type="submit" value="Guardar y Continuar" />
			</div>

			<p>Comparte este set con tus amigos:</p>
			<div class="socialshare">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_pinterest_pinit"></a>
				<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5166023e222d6474"></script>
				<!-- AddThis Button END -->
			</div>
		</form>
	</div>
		<div class="labelSetright rightSetContainer">
			<div class="labelNote">Esta es solo una vista previa. El producto final puede variar un poco.</div>
			<div class="labelSetContainer tipoa" style="background-color: <?php echo $currentcolor->COLOR_CODE?>">
				<img src="<?php echo site_url('library/images/bglabelseta.png')?>" />
				<div class="sticker1">
					<img src="<?php echo site_url('user_files/uploads').'/'.$iconimg?>" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker2">
					<img src="<?php echo site_url('user_files/uploads').'/'.$iconimg?>" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker3">
					<img src="<?php echo site_url('user_files/uploads').'/'.$iconimg?>" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker4">
					<img src="<?php echo site_url('user_files/uploads').'/'.$iconimg?>" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker5">
					<img src="<?php echo site_url('user_files/uploads').'/'.$iconimg?>" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker6">
					<img src="<?php echo site_url('user_files/uploads').'/'.$iconimg?>" />
					<div class="text colorvar curved" style="color: <?php echo $currentcolor->COLOR_CODE?>"><?php echo ascii_to_entities($texto)?></div>
				</div>
			</div>
		</div>
	<div class="clr"></div>
	</div>

		<div id="labelBottom">
			<div id="content_container">
				<div class="labelSetleft">
					<h3>Descripción</h3>
					<p><?php echo strip_tags($sticker->STICKER_DESCRIPTION)?></p>
				</div>
				<div class="labelSetright">
					<h3>Galería de Imágenes</h3>
					<div class="gallery_container">
						<?php foreach($img_gallery as $img):?>
						<div class="image_container"><a href="<?php echo base_url('user_files/uploads/'.$img)?>" rel="lightbox[gallery]"><img src="<?php echo base_url('user_files/uploads/'.$img)?>" height="75" alt="" /></a></div>
						<?php endforeach?>
					</div>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.labelSetContainer .text.curved').arctext({
			radius		: 50
		});
	});
</script>

