
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
			
			<div class="height_divider">&nbsp;</div>
			<h3>Textos</h3>
			<p>Selecciona el tama&ntilde;o de tu etiqueta</p>
		    <div class="btn-group" data-toggle="buttons-radio">
			    <a href="javascript:void(0)" class="btn btn-primary" labelsize="40">Peque&ntilde;a (40)</a>
			    <a href="javascript:void(0)" class="btn btn-primary active" labelsize="20">Mediana (20)</a>
			    <a href="javascript:void(0)" class="btn btn-primary" labelsize="12">Grande (12)</a>
		    </div>
		    <p>&nbsp;</p>
			<p>Ingresa el texto que deseas incluir en el dise&ntilde;o.</p>
			
			<div class="textoBox labelsInputList">
				<label>1</label>
				<input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="1" />
				<hr />
				<label>2</label>
				<input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="2" />
				<hr />
				<label>3</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="3" />
				<hr />
				<label>4</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="4" />
				<hr />
				<label>5</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="5" />
				<hr />
				<label>6</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="6" />
				<hr />
				<label>7</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="7" />
				<hr />
				<label>8</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="8" />
				<hr />
				<label>9</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="9" />
				<hr />
				<label>10</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="10" />
				<hr />
				<label>11</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="11" />
				<hr />
				<label>12</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="12" />
				<hr />
				<label>13</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="13" />
				<hr />
				<label>14</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="14" />
				<hr />
				<label>15</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="15" />
				<hr />
				<label>16</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="16" />
				<hr />
				<label>17</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="17" />
				<hr />
				<label>18</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="18" />
				<hr />
				<label>19</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="19" />
				<hr />
				<label>20</label><input type="text" name="STICKER_LABEL[]" value="" class="labelsText validate[required]" placeholder="Escriba Aquí" number="20" />
			</div>
			
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
			<div class="labelSetContainer tipoc size20" style="background-color: <?php echo $currentcolor->COLOR_CODE?>">
				
				<?php for($i = 0; $i < 20; $i++):?>
				<div class="prevlabel">
					<img src="<?=base_url('user_files/uploads').'/'.$iconimg?>" />
					<span>Escriba Aquí</span>
				</div>
				<?php endfor?>
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
		
		change_label_text();

	display_modal()
	});
	function display_modal(){
		popup_show('<img src="<?php echo site_url('library/images/help_image.gif')?>" alt="Ayuda de proceso"/>');
	}
	
</script>

