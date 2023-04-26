<?php include("../../templates/header.php"); ?>
<?php
include("../../bd.php");

    if($_SESSION['puesto'] != 1){
        header("Location:".$url_base."login.php");
    }

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_preciounico WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_preciounico`");
$sentencia->execute();
$lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

//print_r($lista_tbl_puestos);

?>


<br/>

<div class="card">
    <div class="card-header">
    <!-- <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a> -->
    <h5>Precio por litro</h5>
    </div>
    <div class="card-body">
    <div class="table-responsive-sm">
    <table class="table table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Precio</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_tbl_puestos as $registro){ ?>
            <tr class="">
                <td scope="row"><?php echo $registro['id']?></td>
                <td><?php echo $registro['precio']?></td>
            <td>
            <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']?>" role="button">Editar</a>
            </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    </div>
</div>

<?php include("../../templates/footer.php"); ?>