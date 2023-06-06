<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "carrera";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['NombC']) || empty($_POST['Clave'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $IDCa = $_GET['id'];
        $NombC = $_POST['NombC'];
        $Clave = $_POST['Clave'];
            $sql_update = mysqli_query($conexion, "UPDATE carrera SET NombC = '$NombC', Clave = '$Clave' WHERE IDCa = $IDCa");

            if ($sql_update) {
                $alert = '<div class="alert alert-success" role="alert">Carrera actualizada correctamente</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la carrera</div>';
            }
    }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location: carrera.php");
}
$IDCa = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM carrera WHERE IDCa = $IDCa");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: carrera.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $IDCa = $data['IDCa'];
        $NombC = $data['NombC'];
        $Clave = $data['Clave'];
    }
}
?>
<!-- Contenido de la página inicial -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Carrera
                </div>
                <div class="card-body">
                    <form class="" action="" method="post">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $IDCa; ?>">
                        <div class="form-group">
                            <label for="NombC">Nombre de la Carrera:</label>
                            <input type="text" placeholder="Ingrese el nombre de la carrera" name="NombC" class="form-control" id="NombC" value="<?php echo $NombC; ?>">
                        </div>
                        <div class="form-group">
                            <label for="Clave">Clave de la Carrera:</label>
                            <input type="text" placeholder="Ingrese la Clave de la carrera" name="Clave" class="form-control" id="Clave" value="<?php echo $Clave; ?>">
                        </div>
                   <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i></button>
                    <a href="carrera.php" class="btn btn-danger">Atras</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.Contenedor-fluido -->
<?php include_once "includes/footer.php"; ?> 