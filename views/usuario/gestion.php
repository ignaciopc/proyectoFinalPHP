<?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'complete'): ?>
    <p class="alerta alerta-exito">Usuario actualizado correctamente.</p>
<?php elseif (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'failed'): ?>
    <p class="alerta alerta-error">Ha ocurrido un error al actualizar el usuario.</p>
<?php endif; ?>

<h1>Gestión de Usuarios</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario->id ?></td>
            <td><?= $usuario->nombre ?> <?= $usuario->apellidos ?></td>
            <td><?= $usuario->email ?></td>
            <td><?= $usuario->rol ?></td>
            <td>
                <a href="<?= base_url ?>usuario/editarUsuario&id=<?= $usuario->id ?>">Editar</a>
                <a href="<?= base_url ?>usuario/eliminarUsuario&id=<?= $usuario->id ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
