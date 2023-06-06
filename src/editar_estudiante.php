<?php include_once "includes/header.php";
require "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "alumnos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['Nombre']) || empty($_POST['Email']) || empty($_POST['Teléfono'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $IDA = $_GET['id'];
        $Nombre = $_POST['Nombre'];
        $Email = $_POST['Email'];
        $Teléfono = $_POST['Teléfono'];
        $sql_update = mysqli_query($conexion, "UPDATE alumnos SET Nombre = '$Nombre', Email = '$Email', Teléfono = '$Teléfono' WHERE IDA = $IDA");
        $alert = '<div class="alert alert-success" role="alert">Estudiante Actualizado</div>';
    }
}

// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location: alumnos.php");
}
$IDA = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM alumnos WHERE IDA = $IDA");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: alumnos.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $IDA = $data['IDA'];
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
                Modificar Estudiante
            </div>
            <div class="card-body">
                <form class="" action="" method="post">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <input type="hidden" name="IDA" value="<?php echo $IDA; ?>">
                    <div class="form-group">
                        <label for="Nombre">Nombre del Estudiante:</label>
                        <input type="text" placeholder="Ingrese Nombre" class="form-control" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Email">Correo Electrónico:</label>
                        <input type="text" placeholder="Ingrese Correo electrónico" class="form-control" name="Email" id="Email" value="<?php echo $Email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Teléfono">Teléfono:</label>
                        <input type="number" placeholder="Ingrese Teléfono" class="form-control" name="Teléfono" id="Teléfono" value="<?php echo $Teléfono; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i></button>
                    <a href="alumnos.php" class="btn btn-danger">Atras</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>