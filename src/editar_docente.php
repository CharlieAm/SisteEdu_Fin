<?php include_once "includes/header.php";
require "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "docentes";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['Clave']) || empty($_POST['Nombre']) || empty($_POST['Email']) || empty($_POST['Teléfono'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $id = $_GET['id'];
        $Clave = $_POST['Clave'];
        $Nombre = $_POST['Nombre'];
        $Email = $_POST['Email'];
        $Teléfono = $_POST['Teléfono'];
        $sql_update = mysqli_query($conexion, "UPDATE docentes SET Clave = '$Clave', Nombre = '$Nombre', Email = '$Email' , Teléfono = '$Teléfono' WHERE id = $id");
        $alert = '<div class="alert alert-success" role="alert">Docente Actualizado</div>';
    }
}

// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location: docentes.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM docentes WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: docentes.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $id = $data['id'];
        $Clave = $data['Clave'];
        $Nombre = $data['Nombre'];
        $Email = $data['Email'];
        $Teléfono = $data['Teléfono'];
    }
}
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Modificar Docente
            </div>
            <div class="card-body">
                <form class="" action="" method="post">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="Clave">Clave del Docente:</label>
                        <input type="text" placeholder="Ingrese la nueva clave" class="form-control" name="Clave" id="Clave" value="<?php echo $Clave; ?>">

                    </div>
                    <div class="form-group">
                        <label for="Nombre">Nombre del Docente:</label>
                        <input type="text" placeholder="Ingrese nombre" class="form-control" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>">

                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electronico:</label>
                        <input type="text" placeholder="Ingrese correo" class="form-control" name="Email" id="Email" value="<?php echo $Email; ?>">

                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="number" placeholder="Ingrese Teléfono" class="form-control" name="Teléfono" id="Teléfono" value="<?php echo $Teléfono; ?>">

                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i></button>
                    <a href="docentes.php" class="btn btn-reactive">Atras</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>