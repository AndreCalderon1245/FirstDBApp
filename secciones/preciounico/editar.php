<?php include("../../templates/header.php"); ?>
<?php
include("../../bd.php");

    if($_SESSION['puesto'] != 1){
        header("Location:".$url_base."login.php");
    }

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("SELECT * FROM tbl_preciounico WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $precio=$registro["precio"];
}
if($_POST){
    print_r($_POST);

    // Recolectamos los datos del método POST
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $precio=(isset($_POST["precio"])?$_POST["precio"]:"");
    // Prepara la insercción de los datos
    $sentencia=$conexion->prepare("UPDATE tbl_preciounico SET precio=:precio WHERE id=:id");
    // Asignando los valores que vienen del método POST
    $sentencia->bindParam(":precio",$precio);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje="Registro actualizado";
    header("Location:index.php?mensaje=".$mensaje);
}
?>

<br/>
<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="txtID" class="form-label">ID:</label>
          <input type="text"
          value="<?php echo $txtID;?>"
            class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
        </div>
    
        <div class="mb-3">
          <label for="precio" class="form-label">Precio:</label>
          <input type="text"
          value="<?php echo $precio;?>"
            class="form-control" name="precio" id="precio" aria-describedby="helpId" placeholder="10.76">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>  
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>
<?php include("../../templates/footer.php"); ?>