<?php include("../../templates/header.php"); ?>
<?php
include("../../bd.php");

    if($_SESSION['puesto'] != 1){
        header("Location:".$url_base."login.php");
    }

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("SELECT * FROM tbl_productos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelproducto=$registro["nombredelproducto"];
    $capacidad=$registro["capacidad"];
}
if($_POST){
    // Recolectamos los datos del método POST
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $nombredelproducto=(isset($_POST["nombredelproducto"])?$_POST["nombredelproducto"]:"");
    $capacidad=(isset($_POST["capacidad"])?$_POST["capacidad"]:"");
    // Prepara la insercción de los datos
    $sentencia=$conexion->prepare("UPDATE tbl_productos SET nombredelproducto=:nombredelproducto, capacidad=:capacidad WHERE id=:id");
    // Asignando los valores que vienen del método POST
    $sentencia->bindParam(":nombredelproducto",$nombredelproducto);
    $sentencia->bindParam(":capacidad",$capacidad);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje="Registro actualizado";
    header("Location:index.php?mensaje=".$mensaje);
}
?>

<br/>
<div class="card">
    <div class="card-header">
        Productos
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
          <label for="nombredelproducto" class="form-label">Nombre del producto:</label>
          <input type="text"
          value="<?php echo $nombredelproducto;?>"
            class="form-control" name="nombredelproducto" id="nombredelproducto" aria-describedby="helpId" placeholder="Nombre del producto">
        </div>

        <div class="mb-3">
          <label for="capacidad" class="form-label">Capacidad(L):</label>
          <input type="text"
          value="<?php echo $capacidad;?>"
            class="form-control" name="capacidad" id="capacidad" aria-describedby="helpId" placeholder="10">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>  
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>
<?php include("../../templates/footer.php"); ?>