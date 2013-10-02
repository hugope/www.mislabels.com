
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
			<a class="personalizar" style="background-color: gray;background-image: url(<?php echo base_url('library/images/personalizar.png')?>);background-repeat: no-repeat;" href="<?php echo site_url('etiquetas')?>">
				regresar al cat&aacute;logo
			</a>
			<a href="javascript:void(0)" class="btn btn-primary" onclick="display_modal()"><i class="icon-question-sign icon-white"></i></a>
		</div>
		<div class="clr"></div>
	</div>
	<div class="labelSetleft">
		<form action="<?php echo $formaction?>" method="POST">
			
			<div class="height_divider">&nbsp;</div>
			<h3>Texto</h3>
			<p>Ingresa el texto que desea incluir en el dise&ntilde;o de tus etiquetas.</p>
			<div class="textoBox">
				<div class="input-append">
				<input type="text" onfocus="if(this.value=='<?php echo ascii_to_entities($texto)?>') this.value='';" onblur="if(this.value=='') this.value='<?php echo ascii_to_entities($texto)?>';" value="<?php echo ascii_to_entities($texto)?>" alt="<?php echo ascii_to_entities($texto)?>" name="STICKER_LABEL[]" id="sticker_label"/>
				<a class="btn"><i class="icon-refresh"></i>&nbsp;</a>
				</div>
				<p style="float:left; width:100%;"><span>*El texto debe tener un m&aacute;ximo de 16 caracteres.</span></p>
			</div>
			
			<div class="height_divider">&nbsp;</div>
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

			<div class="well well-large">
				<div class="qtybox"><h3>Cantidad</h3>
					<input type="text" onfocus="if(this.value=='1') this.value='';" onblur="if(this.value=='') this.value='1';" value="1" alt="1" name="STICKER_QUANTITY"/>
					<span></span>
				</div>
				<div class="qtybox"><h3>Precio</h3>
					<span>Q. <?php echo $sticker->STICKER_PRICE?></span>
				</div>
				<div class="qtybox"><h3>Tipo</h3>
					<?php echo form_dropdown('STICKER_TYPE', display_sticker_types())?>
				</div>
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
	<div id="template_btn_container"><a href="javascript:void(0)" class="btn btn-warning btn-large" onclick="display_modal()">Ver Plantilla de Etiqueta</a></div>
		<div class="labelSetright rightSetContainer">
			<div class="labelNote">Esta es solo una vista previa. El producto final puede variar un poco.</div>
			<div class="labelSetContainer tipob" style="color: <?=$sticker->STICKER_TEXT_COLOR?>; background-color:#FFF;">
				<img src="<?php echo site_url('library/images/bglabelseta.png')?>" />
				<div class="sticker1" style="background-image:url(<?php echo site_url('user_files/uploads').'/'.$iconimg[0]?>)" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker2" style="background-image:url(<?php echo site_url('user_files/uploads').'/'.$iconimg[1]?>)" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker3" style="background-image:url(<?php echo site_url('user_files/uploads').'/'.$iconimg[2]?>)" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker4" style="background-image:url(<?php echo site_url('user_files/uploads').'/'.$iconimg[3]?>)" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker5" style="background-image:url(<?php echo site_url('user_files/uploads').'/'.$iconimg[4]?>)" />
					<div class="text"><?php echo ascii_to_entities($texto)?></div>
				</div>
				<div class="sticker6" style="background-image:url(<?php echo site_url('user_files/uploads').'/'.$iconimg[5]?>)" />
					<div class="text colorvar curved"><?php echo ascii_to_entities($texto)?></div>
				</div>
			</div>
		</div>
	<div class="clr"></div>
	</div>

		<div id="labelBottom">
			<div id="content_container">
				<div class="labelSetleft">
					<h3>Descripc&oacute;n</h3>
					<p><?php echo strip_tags($sticker->STICKER_DESCRIPTION)?></p>
				</div>
				<div class="labelSetright">
					<h3>Galer&iacute;a de Im&aacute;genes</h3>
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
	display_modal()
	});
	function display_modal(){
		popup_show('<img src="<?php echo site_url('library/images/help_image.gif')?>" alt="Ayuda de proceso"/>');
	}
</script>

