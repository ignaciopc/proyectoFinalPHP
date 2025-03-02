<?php if (isset($userData)): ?>
    <h1>Editar Usuario</h1>
    <form action="<?= base_url ?>usuario/actualizarUsuario" method="POST">
        <input type="hidden" name="id" value="<?= $userData->id ?>" />
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?= $userData->nombre ?>" required />
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" value="<?= $userData->apellidos ?>" required />
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $userData->email ?>" required />
        
        <label for="rol">Rol:</label>
        <select name="rol" required>
            <option value="user" <?= ($userData->rol == 'user') ? 'selected' : ''; ?>>Usuario</option>
            <option value="admin" <?= ($userData->rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
        </select>
        
        <input type="submit" value="Actualizar Usuario" />
    </form>
<?php else: ?>
    <p>No se pudo encontrar el usuario.</p>
<?php endif; ?>
