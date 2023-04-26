<?php include("../../templates/header.php"); ?>
<?php
include("../../bd.php");

    if($_SESSION['puesto'] != 1){
        header("Location:".$url_base."login.php");
    }

//Imprime la información enviada en el submit
if($_POST){
  print_r($_POST);
  // Recolectamos los datos del método POST
  $idempleado=(isset($_POST["idempleado"])?$_POST["idempleado"]:"");
  $idproducto=(isset($_POST["idproducto"])?$_POST["idproducto"]:"");
  $cantidad=(isset($_POST["cantidad"])?$_POST["cantidad"]:"");
  $subtotal=(isset($_POST["subtotal"])?$_POST["subtotal"]:"");
  $idstatus=(isset($_POST["idstatus"])?$_POST["idstatus"]:"");
  $idpayment=(isset($_POST["idpayment"])?$_POST["idpayment"]:""); 
  $fechadepedido=(isset($_POST["fechadepedido"])?$_POST["fechadepedido"]:""); 
    // Prepara la insercción de los datos
  $sentencia = $conexion->prepare("INSERT INTO tbl_pedidos(id, idempleado, idproducto, cantidad, subtotal, idstatus, idpayment, fechadepedido) VALUES (null, :idempleado, :idproducto, :cantidad, :subtotal, :idstatus, :idpayment, :fechadepedido)");
  // Asignando los valores que vienen del método POST
  $sentencia->bindParam(":idempleado",$idempleado);
  $sentencia->bindParam(":idproducto",$idproducto);
  $sentencia->bindParam(":cantidad",$cantidad);
  $sentencia->bindParam(":subtotal",$subtotal);
  $sentencia->bindParam(":idstatus",$idstatus); 
  $sentencia->bindParam(":idpayment",$idpayment);
  $sentencia->bindParam(":fechadepedido",$fechadepedido);
  $sentencia->execute();
  $mensaje="Registro agregado";
  header("Location:index.php?mensaje=".$mensaje);
}
  $sentencia_subtotal = $conexion->prepare("SELECT DISTINCT *, (SELECT tbl_preciounico.precio * tbl_productos.capacidad FROM tbl_preciounico) AS total FROM `tbl_productos`, `tbl_preciounico`");
  $sentencia_subtotal->execute();
  $lista_tbl_subtotal=$sentencia_subtotal->fetchAll(PDO::FETCH_ASSOC);
  $total = $lista_tbl_subtotal[0]['total'];

  $sentencia_empleados = $conexion->prepare("SELECT DISTINCT * FROM `tbl_empleados`");
  $sentencia_empleados->execute();
  $lista_tbl_empleados = $sentencia_empleados->fetchAll(PDO::FETCH_ASSOC);

  $sentencia_status = $conexion->prepare("SELECT DISTINCT * FROM `tbl_status`");
  $sentencia_status->execute();
  $lista_tbl_status = $sentencia_status->fetchAll(PDO::FETCH_ASSOC);

  $sentencia_productos = $conexion->prepare("SELECT DISTINCT * FROM `tbl_productos`");
  $sentencia_productos->execute();
  $lista_tbl_productos = $sentencia_productos->fetchAll(PDO::FETCH_ASSOC);

  $sentencia_payment = $conexion->prepare("SELECT DISTINCT * FROM `tbl_payment`");
  $sentencia_payment->execute();
  $lista_tbl_payment = $sentencia_payment->fetchAll(PDO::FETCH_ASSOC);
  
  $sentencia_precio = $conexion->prepare("SELECT DISTINCT * FROM `tbl_preciounico`");
  $sentencia_precio->execute();
  $lista_tbl_precio = $sentencia_precio->fetchAll(PDO::FETCH_ASSOC);
?>
</br>
<div class="card">
    <div class="card-header">
        Datos del pedido
    </div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form data">
        <div class="mb-3">
            <label for="idempleado" class="form-label">Nombre del empleado:</label>
            <select class="form-select form-select-sm" name="idempleado" id="idempleado">
              <?php foreach($lista_tbl_empleados as $registro){ ?>
                <option value="<?php echo $registro['id']?>"><?php echo $registro['primernombre'] . " " . $registro['segundonombre'] . " " . $registro['primerapellido'] . " " . $registro['segundoapellido']; ?>
              </option>
              <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="idproducto" class="form-label">Nombre del producto:</label>
            <select class="form-select form-select-sm" name="idproducto" id="idproducto">
              <?php foreach($lista_tbl_productos as $registro){ ?>
                <option value="<?php echo $registro['id']?>"><?php echo $registro['nombredelproducto']; ?>
              </option>
              <?php } ?>
            </select>
        </div>
        <div class="mb-3">
          <label for="cantidad" class="form-label">Cantidad:</label>
          <input type="number"
            class="form-control" name="cantidad" id="cantidad" aria-describedby="helpId" placeholder="1">
        </div>
        <div class="mb-3">
        <label for="subtotal" class="form-label">Subtotal:</label>
        <input type="text"
          class="form-control" readonly name="subtotal" id="resultado" aria-describedby="helpId" placeholder="$<?php echo $total; ?>">
        </div>
        <div class="mb-3">
          <div class="mb-3">
            <label for="idstatus" class="form-label">Estatus:</label>
            <select class="form-select form-select-sm" name="idstatus" id="idstatus">
              <?php foreach($lista_tbl_status as $registro){ ?>
                <option value="<?php echo $registro['id']?>"><?php echo $registro['status']; ?>
              </option>
              <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="idpayment" class="form-label">Metodo de pago:</label>
            <select class="form-select form-select-sm" name="idpayment" id="idpayment">
              <?php foreach($lista_tbl_payment as $registro){ ?>
                <option value="<?php echo $registro['id']?>"><?php echo $registro['payment']; ?>
              </option>
              <?php } ?>
            </select>
        </div>
        <div class="mb-3">
          <label for="fechadepedido" class="form-label">Fecha de pedido:</label>
          <input type="date" class="form-control" name="fechadepedido" id="fechadepedido" aria-describedby="emailHelpId" placeholder="Fecha de pedido">
        </div>
        <button type="submit" class="btn btn-success">Crear pedido</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>