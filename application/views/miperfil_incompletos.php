<h2><span>Bienvenido, </span><?php echo $this->session->userdata('CUSTOMER_NAME')?></h2>
	<div class="profile_pedidos">
				<h3>Pedidos Incompletos</h3>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php foreach($incomplete as $order):?>
				  	<tr>
				  	 	<td  align="right"><a href="<?php echo site_url('carrito/index/'.$order->ID)?>"><?php echo $order->SHOPPING_CODE?></a></td>
				  	 	<td class="secondGrey"><?php echo mysql_date_to_dmy($order->SHOPPING_DATECREATED)?></td>
				  	</tr>
				  	<?php endforeach?>
				 </table>
				</div>