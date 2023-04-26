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
    $nombredelproducto=(isset($_POST["nombredelproducto"])?$_POST["nombredelproducto"]:"");
    $capacidad=(isset($_POST["capacidad"])?$_POST["capacidad"]:"");
    // Prepara la insercción de los datos
    $sentencia=$conexion->prepare("INSERT INTO tbl_productos(id,nombredelproducto,capacidad,idpreciounico) VALUES (null,:nombredelproducto,:capacidad,1)");
    // Asignando los valores que vienen del método POST
    $sentencia->bindParam(":nombredelproducto",$nombredelproducto);
    $sentencia->bindParam(":capacidad",$capacidad);
    $sentencia->execute();
    $mensaje="Registro agregado";
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
          <label for="nombredelproducto" class="form-label">Nombre del producto:</label>
          <input type="text"
            class="form-control" name="nombredelproducto" id="nombredelproducto" aria-describedby="helpId" placeholder="Nombre del producto">
        </div>
        <div class="mb-3">
          <label for="capacidad" class="form-label">Capacidad(L):</label>
          <input type="number"
            class="form-control" name="capacidad" id="capacidad" aria-describedby="helpId" placeholder="10">
        </div>
        <button type="subnmit" class="btn btn-success">Agregar</button>  
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templates/footer.php"); ?>