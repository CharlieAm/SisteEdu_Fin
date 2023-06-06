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
        $alert = '<div class="alert alert-danger" role="alert">
        Todo los campos son obligatorios
        </div>';
    } else {
        $IDG = $_POST['IDG'];
        $ClaveG = $_POST['ClaveG'];
        $query = mysqli_query($conexion, "SELECT * FROM grupos where ClaveG = '$ClaveG'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                        El grupo ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO grupos(IDG, ClaveG) values ('$IDG', '$ClaveG')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Grupo registrado
                        </div>';
                header("Location: grupos.php");
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar
                    </div>';
            }
        }
    }
}
?>
<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#nuevo_grupo"><i class="fas fa-plus"></i></button>
<div id="nuevo_grupo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Grupo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="ClaveG">Clave del Grupo:</label>
                        <input type="text" class="form-control" placeholder="Ingrese el clave del grupo" name="ClaveG" id="ClaveG">
                    </div>
                    <div class="form-group">
                        <label for="Estado">Estado:</label>
                        <input type="number" class="form-control" placeholder="Ingrese estado" name="Estado" id="Estado">
                    </div>
                    <input type="submit" value="Registrar Grupo" class="btn btn-primary" href="grupos.php">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>IDG</th>
                <th>Clave del Grupo</th>
                <th>Estado</th>
                <th>Configuración</th>
            </tr>
        </thead>
        <tbody>
            <?php ?>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY Estado DESC");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    if ($data['Estado'] == 1) {
                        $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                    } else {
                        $estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                    }
            ?>
                    <tr>
                        <td><?php echo $data['IDG']; ?></td>
                        <td><?php echo $data['ClaveG']; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['Estado'] == 1) { ?>
                                <a href="editar_grupo.php?id=<?php echo $data['IDG']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_grupo.php?id=<?php echo $data['IDG']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<?php include_once "includes/footer.php"; ?>