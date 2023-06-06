<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "grupos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['ClaveG'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todo los campos son requeridos</div>';
    } else {
        $IDG = $_POST['IDG'];
        $ClaveG = $_POST['ClaveG'];
        $sql_update = mysqli_query($conexion, "UPDATE grupos SET ClaveG = '$ClaveG' WHERE IDG = $IDG");
            if ($sql_update) {
                $alert = '<div class="alert alert-success" role="alert">Grupos actualizada correctamente</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el grupo</div>';
            }
    }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location: grupos.php");
}
$IDG = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM grupos WHERE IDG = $IDG");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: grupos.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $IDG = $data['IDG'];
        $ClaveG = $data['ClaveG'];
    }
}
?>
<!-- Contenido de la página inicial -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar grupos
                </div>
                <div class="card-body">
                    <form class="" action="" method="post">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="IDG" value="<?php echo $IDG; ?>">
                        <div class="form-group">
                            <label for="ClaveG">ClaveG de la grupos:</label>
                            <input type="text" placeholder="Ingrese la nueva Clave del grupo" name="ClaveG" class="form-control" id="ClaveG" value="<?php echo $ClaveG; ?>">
                        </div>
                   <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i></button>
                    <a href="grupos.php" class="btn btn-danger">Atras</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.Contenedor-fluido -->
<?php include_once "includes/footer.php"; ?> 