<style>  

  * {
    font-family: Open Sans, Helvetica, Arial, sans-serif;
  }

table {width: 100%; border-collapse: collapse;}
  td, th {border: solid 1px black;}


  h1 {
    text-align: center;
    margin-bottom: -10px;
    margin-top: 60px;
    font-weight: 800;

  }


  h2 {
    display: inline-block;
    margin-bottom: 0px;
    margin-left: 30px;
    margin-top: 13px;
    font-size: 42px;
    font-weight: 800;
    color: white;
  }


  .datos {
    float: right;
    margin-top: 100px
  }

  .empresa {
    float: left;
    background: #18b898;
    width: 100%;
    height: 80px;
  }

  p {
    text-align: center;
  }

  thead, tbody {text-align: center;}
  

  #general {
    margin-top: 125px;
  }

</style>


<span class="empresa">
  <h2>
    Psicologia Integral
  </h2>
  
</span>



<span class="datos">
  <span style="display: block;"><b>Factura: </b> <span style="margin-left: 60px">#00000<?php echo $id_ses ?></span></span>
  <b>Fecha: </b> <?php echo $productos['fecha_venta'] ?> <br>
</span>




<div id="general">
  <span>
  <h1>¡Gracias por su orden!</h1>
  <p>Hemos recibido tu pago <?php echo $nombres ?>, aquí tenemos el resumen de tu compra:</p>
</span>

<table>
  <thead>
    <tr>
      <th width="10%">#</th>
      <th width="45%">Profesional</th>
      <th width="15%">Cantidad Horas</th>
      <th width="15%">Precio / hora.</th>
      <th width="15%">Subtotal</th>
    </tr>
  </thead>
  
  

  <tbody>
  <?php $codigo = 0; ?>
  <?php foreach($productos['productos'] as $producto): ?>
    <?php $codigo = $codigo + 1; ?>
    <tr>
      <td><?php echo $codigo; ?></td>
      <td><?php echo $producto['nombre']; ?></td>
      <td><?php echo $producto['cantidad']; ?></td>
      <td><?php echo number_format($producto['precio'] , 2 , '.' , "' ") ?></td>
      <td><?php echo number_format(($producto['cantidad'] * $producto['precio']) , 2, '.' , "' ") ?></td>
    </tr>
  <?php endforeach; ?>
    <tr>
      <td colspan="4" style="text-align: right; font-weight: bold; font-size: 20px">Total $</td>
      <td>
        <?php echo number_format($productos['cart_totals']['total'], 2, '.' , "' ") ?>
      </td>
      </tr>        
  </tbody>
</table>


<div class="">
  <h4 style="margin-bottom: -10px;">Dirección de entrega</h4>
  <p style="text-align: left; margin-bottom: 15px;">
    <span style="display: block;">
      <?php echo $direccion; ?>
    </span>
  </p>
</div>

</div>
  
