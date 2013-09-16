			<div class="myProfile_navbox">
				<ul>
					<?php foreach($btns as $btn):?>
					<li><a href="<?php echo site_url('miperfil/'.$btn->CLASS)?>" class="<?php echo $btn->ACTIVE?>"><?php echo $btn->LABEL?></a></li>
					<?php endforeach?>
				</ul>
				<div class="clr"></div>
			</div>