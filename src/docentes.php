<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "docentes";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['Clave']) || empty($_POST['Nombre']) || empty($_POST['Email']) || empty($_POST['Teléfono']) || empty($_POST['Estado'])) {
        $alert = '<div class="alert alert-danger" role="alert">
        Todo los campos son obligatorios
        </div>';
    } else {
        $Clave = $_POST['Clave'];
        $Nombre = $_POST['Nombre'];
        $Email = $_POST['Email'];
        $Teléfono = $_POST['Teléfono'];
        $Estado = $_POST['Estado'];
        $query = mysqli_query($conexion, "SELECT * FROM docentes where Email = '$Email'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                        El correo ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO docentes(Clave,Nombre,Email,Teléfono, Estado) values ('$Clave', '$Nombre', '$Email', '$Teléfono', '$Estado')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Docente registrado
                        </div>';
                header("Location: docentes.php");
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar
                    </div>';
            }
        }
    }
}
?>
<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#nuevo_docente"><i class="fas fa-plus"></i></button>
<div id="nuevo_docente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Docente</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="Clave">Clave del Docente:</label>
                        <input type="text" class="form-control" placeholder="Ingrese la Clave" name="Clave" id="Clave">
                    </div>
                    <div class="form-group">
                        <label for="Nombre">Nombre Completo:</label>
                        <input type="text" class="form-control" placeholder="Ingrese el Nombre Completo del docente" name="Nombre" id="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="Email">Correo Electrónico :</label>
                        <input type="Email" class="form-control" placeholder="Ingrese Correo Electrónico" name="Email" id="Email">
                    </div>
                    <div class="form-group">
                        <label for="Teléfono">Teléfono:</label>
                        <input type="number" class="form-control" placeholder="Ingrese Teléfono" name="Teléfono" id="Teléfono">
                    </div>
                    <div class="form-group">
                        <label for="Estado">Estado:</label>
                        <input type="number" class="form-control" placeholder="Ingrese estado" name="Estado" id="Estado">
                    </div>
                    <input type="submit" value="Registrar Docente" class="btn btn-primary">
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
                <th>Clave del Docente</th>
                <th>Nombre Completo</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Configuración</th>
            </tr>
        </thead>
        <tbody>
            <?php ?>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT * FROM docentes ORDER BY Estado DESC");
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

                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['Clave']; ?></td>
                        <td><?php echo $data['Nombre']; ?></td>
                        <td><?php echo $data['Email']; ?></td>
                        <td><?php echo $data['Teléfono']; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['Estado'] == 1) { ?>
                                <a href="editar_docente.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_docente.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            <?php } if ($data['Estado'] == 0) { ?>
                                    <form action="reactivar_docente.php?id=<?php echo $data['id']; ?>" method="post" class="reactive d-inline">
                                    <button class="btn btn-reactive" type="submit"><i class='fas fa-trash-alt'></i> </button>
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