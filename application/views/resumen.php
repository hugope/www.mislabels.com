
<div class="clr"></div>
</div></div>

<div class="bodyContent">
<div class="wrapper_profilebody">
	<?php echo $wizard_menu?>
<div class="wrapper_whitebox">
<div class="regA1box"><h1>Resumen</h1></div>

<div class="resumeSummary">
<div class="pedidobox">
<h3>Pedido <a href="<?php echo site_url('carrito')?>"><img src="<?php echo base_url('library/images/edit_tem.png');?>" alt="Edit" /></a></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Descripci&oacute;n</th>
    <th>Cantidad</th>
    <th>Tipo</th>
    <th>Precio Unitario</th>
    <th align="right" style="padding-right:20px;">Total</th>
  </tr>
  <?php foreach($stickers as $sticker):?>
  <tr>
				<td>Label Set <?php echo $sticker->STICKER_NAME?></td>
				<td><?php echo $sticker->STICKER_QUANTITY?></td>
				<td><?php echo $sticker->LABEL?></td>
				<td>Q. <?php echo $this->cart->format_number($sticker->STICKER_PRICE)?></td>
				<td>Q. <?php echo $this->cart->format_number($sticker->STICKER_TOTAL)?></td>
  </tr>
  <?php endforeach?>
</table>
<div class="second_subtotal"><strong>Subtotal (Q.)</strong><span><?php echo $this->cart->format_number($cartTotal)?></span></div>
</div>

<div class="pedido_bottombox">
<div class="pedido_entrega">
<h3>Entrega <a href="<?php echo site_url('entrega/configurar/'.$cartid)?>"><img src="<?php echo base_url('library/images/edit_tem.png');?>" alt="Edit" /></a></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="right">Destino</td>
    <td class="gryColor"><?php echo localidades_caex($envio->SHIPPING_CITY)?></td>
  </tr>
 <tr>
    <td  align="right">Recibe</td>
    <td class="gryColor"><?php echo $carro->SHOPPING_RECEIVER?></td>
  </tr>
  
  <tr>
    <td  align="right">Direcci&oacute;n</td>
    <td class="gryColor"><?php echo $envio->SHIPPING_ADDRESS?></td>
  </tr>
  <tr>
    <th  align="right">&nbsp;</th>
    <th class="gryColor">&nbsp;</th>
  </tr>
</table>
<div class="tabsubtot"><strong>Total (Q.)</strong><span><?php echo $this->cart->format_number($costoEnvio)?></span></div>
</div>
<div class="pedido_entrega">
<h3>Facturaci&oacute;n <a href="<?php echo site_url('factura/configurar/'.$cartid)?>"><img src="<?php echo base_url('library/images/edit_tem.png');?>" alt="Edit" /></a></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="right">Nombre</td>
    <td class="gryColor"><?php echo $carro->SHOPPING_CUSTOMER_BILLINGNAME?></td>
  </tr>
 <tr>
    <td  align="right">NIT</td>
    <td class="gryColor"><?php echo $carro->SHOPPING_CUSTOMER_BILLINGTIN?></td>
  </tr>
  
  <tr>
    <td  align="right">Direcci&oacute;n</td>
    <td class="gryColor"><?php echo $carro->SHOPPING_CUSTOMER_BILLINGLOCATION?></td>
  </tr>
</table>  
</div>
<div class="pedido_totalpagar">
<div class="totalpagarGrey">
<h3>Total a Pagar</h3>
<p>Pedido (Q.)<span><?php echo $this->cart->format_number($cartTotal)?></span></p>
<p>Env&iacute;o (Q.)<span><?php echo $this->cart->format_number($costoEnvio)?></span></p>
<h4>Total (Q.)<span><?php echo $this->cart->format_number($cartTotal + $costoEnvio)?></span></h4>
</div>

<div class="totalpagar_lightOrang">
<a href="<?php echo site_url('pago/configurar/'.$cartid)?>"><img src="<?php echo base_url('library/images/pagaonline.png');?>" alt="Pagar" /></a>
<p>Aceptamos todas las tarjetas de cr&eacute;dito.</p>
<a href="<?php echo site_url('pago/configurar/'.$cartid)?>"><img src="<?php echo base_url('library/images/masterCard.jpg');?>" alt="Pagar" /></a>
<p>&nbsp;</p>
<a href="<?php echo site_url('pago/respuesta/'.$cartid).'/?PAYMENT_TYPE=POST&response=1&responsetext=post%20pago%20'?>"><img src="<?php echo base_url('library/images/otras.png');?>" alt="Pagar" /></a>
<p>Estaremos en contacto para verificar su pago por otros medios*.</p>
</div>
</div>
<div class="clr"></div>
<p>*Tome en consideraci&oacute;n que su pedido no ser&aacute; procesado hasta que su pago haya sido verificado.</p>
</div>
</div>

<div class="gereyback_bottom">
<!--<div class="login_heading"><h3>Ingresa a Tu Cuenta</h3></div>
<div class="register_heading"><h3>Reg&iacute;strate</h3></div>
<div class="clr"></div>-->
</div>

<div class="clr"></div>
</div>
</div></div>