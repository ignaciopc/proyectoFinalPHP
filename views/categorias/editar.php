<h1>Editar Categoría</h1>

<?php if (isset($categoria) && is_object($categoria)): ?>
    <form action="<?= base_url ?>categoria/update" method="POST">
        <input type="hidden" name="id" value="<?= $categoria->id ?>">

        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" name="nombre" value="<?= $categoria->nombre ?>" required>

        <button type="submit" class="button guardar">Guardar Cambios</button>
        <a href="<?= base_url ?>categoria/index" class="button cancelar">Cancelar</a>
    </form>
<?php else: ?>
    <p class="error">La categoría no existe.</p>
<?php endif; ?>
