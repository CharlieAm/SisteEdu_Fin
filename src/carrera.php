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
    if (empty($_POST['NombC']) || empty($_POST['Clave']) || empty($_POST['Estado'])) {
        $alert = '<div class="alert alert-danger" role="alert">
        Todo los campos son obligatorios
        </div>';
    } else {
        $NombC = $_POST['NombC'];
        $Clave = $_POST['Clave'];
        $Estado = $_POST['Estado'];
        $query = mysqli_query($conexion, "SELECT * FROM carrera where NombC = '$NombC'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                        La carrera ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO carrera(NombC,Clave,Estado) values ('$NombC', '$Clave', '$Estado')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Carrera registrada
                        </div>';
                header("Location: carrera.php");
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
                <h5 class="modal-title" id="my-modal-title">Nueva Carrera</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="NombC">Nombre de la carrera</label>
                        <input type="text" class="form-control" placeholder="Ingrese el nombre de la carrera" name="NombC" id="NombC">
                    </div>
                    <div class="form-group">
                        <label for="Clave">Clave de la carrera:</label>
                        <input type="text" class="form-control" placeholder="Ingrese la clave de la carrera" name="Clave" id="Clave">
                    </div>
                    <div class="form-group">
                        <label for="Estado">Estado:</label>
                        <input type="number" class="form-control" placeholder="Ingrese cel estado" name="Estado" id="Estado">
                    </div>
                    <input type="submit" value="Registrar Carrera" class="btn btn-primary" href="carrera.php">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre de la Carrera</th>
                <th>Clave</th>
                <th>Estado</th>
                <th>Configuración</th>
            </tr>
        </thead>
        <tbody>
            <?php ?>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM carrera ORDER BY Estado DESC");
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

                        <td><?php echo $data['IDCa']; ?></td>
                        <td><?php echo $data['NombC']; ?></td>
                        <td><?php echo $data['Clave']; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['Estado'] == 1) { ?>
                                <a href="editar_carrera.php?id=<?php echo $data['IDCa']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_carrera.php?id=<?php echo $data['IDCa']; ?>" method="post" class="confirmar d-inline">
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