<h1>Gestionar Categorias</h1>
<div class="categorias-wrapper">
    <h2 class="categorias-titulo">Listado de Categorías</h2>

    <?php if (!empty($categorias)): ?>
        <?php foreach ($categorias as $categoria): ?>
            <div class="categoria-item">
                <p class="categoria-id">ID: <?php echo $categoria['id']; ?></p>
                <p class="categoria-nombre"><?php echo $categoria['nombre']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay categorías disponibles.</p>
    <?php endif; ?>
</div>

<div class="button-container">
    <a href="<?= base_url ?>categoria/crear" class="button">
        <button class="button">Agregar Categoría</button>
    </a>
</div>