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
  $primernombre=(isset($_POST["primernombre"])?$_POST["primernombre"]:"");
  $segundonombre=(isset($_POST["segundonombre"])?$_POST["segundonombre"]:"");
  $primerapellido=(isset($_POST["primerapellido"])?$_POST["primerapellido"]:"");
  $segundoapellido=(isset($_POST["segundoapellido"])?$_POST["segundoapellido"]:"");
  //  $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");
  $idpuesto=(isset($_POST["idpuesto"])?$_POST["idpuesto"]:"");
  $fechadeingreso=(isset($_POST["fechadeingreso"])?$_POST["fechadeingreso"]:"");
  $usuario=(isset($_POST["usuario"])?$_POST["usuario"]:"");
  $password=(isset($_POST["password"])?$_POST["password"]:"");
    // Prepara la insercción de los datos
  $sentencia=$conexion->prepare("INSERT INTO tbl_empleados(id,primernombre,segundonombre,primerapellido,segundoapellido,idpuesto,fechadeingreso,usuario,password) VALUES (null,:primernombre,:segundonombre,:primerapellido,:segundoapellido,:idpuesto,:fechadeingreso,:usuario,:password)");
  // Asignando los valores que vienen del método POST
  $sentencia->bindParam(":primernombre",$primernombre);
  $sentencia->bindParam(":segundonombre",$segundonombre);
  $sentencia->bindParam(":primerapellido",$primerapellido);
  $sentencia->bindParam(":segundoapellido",$segundoapellido);
  //  $sentencia->bindParam(":foto",$foto);
  $sentencia->bindParam(":idpuesto",$idpuesto); 
  $sentencia->bindParam(":fechadeingreso",$fechadeingreso);
  $sentencia->bindParam(":usuario",$usuario); 
  $sentencia->bindParam(":password",$password);
  $sentencia->execute();
  $mensaje="Registro agregado";
  header("Location:index.php?mensaje=".$mensaje);
}
  $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
  $sentencia->execute();
  $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
?>


</br>
<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form data">
        <div class="mb-3">
          <label for="primernombre" class="form-label">Primer nombre:</label>
          <input type="text"
            class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
        </div>
        <div class="mb-3">
          <label for="segundonombre" class="form-label">Segundo Nombre:</label>
          <input type="text"
            class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
        </div>
        <div class="mb-3">
          <label for="primerapellido" class="form-label">Primer apellido:</label>
          <input type="text"
            class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
        </div>
        <div class="mb-3">
          <label for="segundoapellido" class="form-label">Segundo apellido:</label>
          <input type="text"
            class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">
        </div>
        <div class="mb-3">
            <label for="idpuesto" class="form-label">Puesto:</label>
            <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
              <?php foreach($lista_tbl_puestos as $registro){ ?>
                <option value="<?php echo $registro['id']?>"><?php echo $registro['nombredelpuesto']?></option>
              <?php } ?>
            </select>
        </div>
        <div class="mb-3">
          <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
          <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
        </div>
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario:</label>
          <input type="text"
            class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Usuario">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password"
            class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-success">Agregar registro</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>