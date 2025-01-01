<?php include_once 'Views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <h4 class="card-title">Gestión de Usuarios</h4>
            <button class="btn btn-primary btn-sm ms-auto" type="button" onclick="abrirModal()">
                <i class="fas fa-plus"></i> Nuevo
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tblUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['usuarios'] as $usuario) { 
                        $estado = $usuario['estado'] == 1 ? 
                            '<span class="badge bg-success">Activo</span>' : 
                            '<span class="badge bg-danger">Inactivo</span>';
                    ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['nombres']; ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['rol']; ?></td>
                            <td><?php echo $estado; ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" type="button" onclick="editarUsuario(<?php echo $usuario['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" type="button" onclick="eliminarUsuario(<?php echo $usuario['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Usuario -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmUsuario">
                <div class="modal-body">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <div class="mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="clave">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_rol">Rol</label>
                        <select class="form-select" id="id_rol" name="id_rol" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($data['roles'] as $rol) { ?>
                                <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnAccion">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer-admin.php'; ?>

<script>
function editarUsuario(id) {
    document.getElementById('tituloModal').textContent = 'Actualizar Usuario';
    document.getElementById('btnAccion').textContent = 'Actualizar';
    
    fetch(BASE_URL + 'usuarios/editar/' + id)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                document.getElementById('id_usuario').value = data.usuario.id;
                document.getElementById('nombre').value = data.usuario.nombres;
                document.getElementById('correo').value = data.usuario.email;
                document.getElementById('id_rol').value = data.usuario.id_rol;
                $('#modalUsuario').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Usuario no encontrado'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al obtener los datos del usuario'
            });
        });
}

function eliminarUsuario(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(BASE_URL + 'usuarios/eliminar/' + id, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire(
                        'Eliminado',
                        data.msg,
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        data.msg,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al eliminar el usuario',
                    'error'
                );
            });
        }
    });
}
</script>

<!-- Scripts específicos -->
<script src="<?php echo BASE_URL; ?>assets/js/modulos/usuarios.js"></script>