<h2><span>Bienvenido, </span><?php echo $this->session->userdata('CUSTOMER_NAME')?></h2>
	<div class="profile_pedidos">
				<h3>Historial de Pedidos</h3>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php foreach($historical as $order):?>
				  	<tr>
				  	 	<td  align="right"><?php echo $order->SHOPPING_CODE?></td>
				  	 	<td class="secondGrey"><?php echo mysql_date_to_dmy($order->SHOPPING_DATECREATED)?></td>
				  	 	<td><span class="badge badge-<?php echo strtolower( $order->SHOPPING_STATUS ) ?>"><?php echo $order->SHOPPING_STATUS?></span></td>
				  	</tr>
				  	<?php endforeach?>
				 </table>
				</div>