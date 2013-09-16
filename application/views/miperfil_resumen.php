<h2><span>Bienvenido, </span><?php echo $this->session->userdata('CUSTOMER_NAME')?></h2>
				<div class="profile_miperfil">
					<h3>Entrega </h3>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td  align="right">Nombre</td>
					    <td class="secondGrey"><?php echo $perfil->CUSTOMER_NAME?></td>
					  </tr>
					 <tr>
					    <td  align="right">Apellido</td>
					    <td class="secondGrey"><?php echo $perfil->CUSTOMER_LASTNAME?></td>
					  </tr>
					  
					  <tr>
					    <td  align="right">Email</td>
					    <td class="secondGrey"><?php echo $perfil->CUSTOMER_EMAIL?></td>
					  </tr>
					 <tr>
					    <td  align="right">Tel&eacute;fono</td>
					    <td class="secondGrey"><?php echo $perfil->CUSTOMER_PHONE?></td>
					  </tr>
					  
					 <tr>
					    <td  align="right">Pa&iacute;s</td>
					    <td class="secondGrey"><?php echo world_countries($perfil->CUSTOMER_COUNTRY)?></td>
					  </tr>
					  
					 <tr>
					    <td  align="right">Direcci&oacute;n</td>
					    <td class="secondGrey"><?php echo $perfil->CUSTOMER_ADDRESS?></td>
					  </tr>
					</table>
					<div class="editButton"><a href="<?php echo site_url('miperfil/datos')?>"><img src="<?php echo site_url('library/images/miPerfil.png')?>" alt="Mi Perfil" /></a></div>
				</div>
				<div class="profile_historial">
				<h3>Historial de Pedidos</h3>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php foreach($historical as $order):?>
				  <tr>
				    <td  align="right"><?php echo $order->SHOPPING_CODE?></td>
				    <td class="secondGrey"><?php echo mysql_date_to_dmy($order->SHOPPING_DATECREATED)?></td>
				    <td><?php echo $order->SHOPPING_STATUS?></td>
				  </tr>
				  <?php endforeach?>
				 </table>
				 <div class="editButton"><a href="<?php echo site_url('miperfil/historial')?>"><img src="<?php echo site_url('library/images/hitorial.jpg')?>" alt="Mi Perfil" /></a></div> 
				</div>
				<div class="profile_pedidos">
				<h3>Pedidos Incompletos</h3>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php foreach($incomplete as $order):?>
				  	<tr>
				  	 	<td  align="right"><?php echo $order->SHOPPING_CODE?></td>
				  	 	<td class="secondGrey"><?php echo mysql_date_to_dmy($order->SHOPPING_DATECREATED)?></td>
				  	</tr>
				  	<?php endforeach?>
				 </table>
				 <div class="editButton"><a href="<?php echo site_url('miperfil/incompletos')?>"><img src="<?php echo site_url('library/images/pendidos.jpg')?>" alt="Mi Perfil" /></a></div>
				</div>
				<div class="clr"></div>