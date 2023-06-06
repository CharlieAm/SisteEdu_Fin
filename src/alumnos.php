<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "alumnos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['Num_Control']) || empty($_POST['Nombre']) || empty($_POST['Email']) || empty($_POST['Teléfono']) || empty($_POST['Estado'])) {
        $alert = '<div class="alert alert-danger" role="alert">
        Todo los campos son obligatorios
        </div>';
    } else {
        $Num_Control = $_POST['Num_Control'];
        $Nombre = $_POST['Nombre'];
        $Email = $_POST['Email'];
        $Teléfono = $_POST['Teléfono'];
        $Estado = $_POST['Estado'];
        $query = mysqli_query($conexion, "SELECT * FROM alumnos where Email = '$Email'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
            $alert = '<div class="alert alert-warning" role="alert">
                        El correo ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO alumnos(Num_Control,Nombre,Email,Teléfono, Estado) values ('$Num_Control', '$Nombre', '$Email', '$Teléfono', '$Estado')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Estudiante registrado
                        </div>';
                header("Location: alumnos.php");
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar
                    </div>';
            }
        }
    }
}
?>
<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#nuevo_estudiante"><i class="fas fa-plus"></i></button>
<div id="nuevo_estudiante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Estudiante</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nce">No. de Control:</label>
                        <input type="number" class="form-control" placeholder="Ingrese el número de control" name="Num_Control" id="Num_Control">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre Completo:</label>
                        <input type="text" class="form-control" placeholder="Ingrese el nombre completo del estudiante" name="Nombre" id="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="Email">Correo Electrónico:</label>
                        <input type="email" class="form-control" placeholder="Ingrese correo electrónico" name="Email" id="Email">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="number" class="form-control" placeholder="Ingrese teléfono" name="Teléfono" id="Teléfono">
                    </div>
                    <div class="form-group">
                        <label for="Estado">Estado:</label>
                        <input type="number" class="form-control" placeholder="Ingrese estado" name="Estado" id="Estado">
                    </div>
                    <input type="submit" value="Registrar Estudiante" class="btn btn-primary" href="alumnos.php">
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
                <th>No de Control</th>
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

            $query = mysqli_query($conexion, "SELECT * FROM alumnos ORDER BY Estado DESC");
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

                        <td><?php echo $data['IDA']; ?></td>
                        <td><?php echo $data['Num_Control']; ?></td>
                        <td><?php echo $data['Nombre']; ?></td>
                        <td><?php echo $data['Email']; ?></td>
                        <td><?php echo $data['Teléfono']; ?></td>
                        <td><?php echo $estado; ?></td>
                        <td>
                            <?php if ($data['Estado'] == 1) { ?>
                                <a href="editar_estudiante.php?id=<?php echo $data['IDA']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                <form action="eliminar_estudiante.php?id=<?php echo $data['IDA']; ?>" method="post" class="confirmar d-inline">
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