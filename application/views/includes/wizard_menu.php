
<div class="profileStepbox">
	<ul>
		<?php foreach($stages as $i => $stage):?>
		<?php $wizard_menu = ($i == 0)?site_url('carrito'):site_url($stage->CLASS.'/configurar/'.$this->uri->segment(3));?>
		<li><a href="javascript:void(0);" class="wizzard_arrow <?php echo $stage->ACTIVE?>"><span class="step"><?=$i?></span> <span class="label"><?php echo $stage->LABEL?></span><span class="right_arrow"></span></a></li>
		<?php endforeach?>
	</ul>
	<div class="clr"></div>
</div>