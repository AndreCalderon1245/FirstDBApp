<?php include("../../templates/header.php"); ?>

<?php
include("../../bd.php");

    if($_SESSION['puesto'] > 3){
        header("Location:".$url_base."login.php");
    }

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_pedidos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT tbl_pedidos.*, (SELECT payment FROM tbl_payment WHERE tbl_payment.id=tbl_pedidos.idpayment limit 1) as metododepago, (SELECT nombredelproducto FROM tbl_productos WHERE tbl_productos.id=tbl_pedidos.idproducto limit 1) as producto , (SELECT concat(primernombre, ' ', segundonombre, ' ', primerapellido, ' ', segundoapellido) FROM tbl_empleados WHERE tbl_empleados.id=tbl_pedidos.idempleado limit 1) as nombredelempleado, (SELECT status FROM tbl_status WHERE tbl_status.id=tbl_pedidos.idstatus limit 1) as status FROM tbl_pedidos, `tbl_preciounico`");
$sentencia->execute();
$lista_tbl_pedidos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

//print_r($lista_tbl_puestos);

?>
<br/>

<div class="card">
    <div class="card-header">
    <?php if($_SESSION['puesto'] != 3){?>
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar pedido</a>
    <?php }else{ ?>
          <h5>Pedidos</h5>
    <?php    } ?>
    </div>
    <div class="card-body">
    <div class="table-responsive-sm">
    <table class="table table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre del empleado</th>
                <th scope="col">Nombre del producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Status</th>
                <th scope="col">Metodo de pago</th>
                <th scope="col">Fecha de pedido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_tbl_pedidos as $registro){ ?>
            <tr class="">
                <td scope="row"><?php echo $registro['id']?></td>
                <td><?php echo $registro['nombredelempleado']?></td>
                <td><?php echo $registro['producto']?></td>
                <td><?php echo $registro['cantidad']?></td>
                <td><?php echo $registro['subtotal']?></td>
                <td><?php echo $registro['status']?></td>
                <td><?php echo $registro['metododepago']?></td>
                <td><?php echo $registro['fechadepedido']?></td>
            <td>
            <?php if($_SESSION['puesto'] != 3){?>
            <a class="btn btn-info" href="ticket.php?txtID=<?php echo $registro['id']?>" role="button">Recibo</a>
            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id'];?>)" role="button">Eliminar</a>
            </td>
            </tr>
            <?php }else{ ?>
                <a class="btn btn-info" href="ticket.php?txtID=<?php echo $registro['id']?>" role="button">Recibo</a>
            <?php    } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
    </div>
</div>

<?php include("../../templates/footer.php"); ?>