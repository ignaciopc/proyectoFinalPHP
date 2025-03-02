    <h1>Gestionar Categorías</h1>

    <div class="categorias-wrapper">
        <h2 class="categorias-titulo">Listado de Categorías</h2>

        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $categoria): ?>
                <div class="categoria-item">
                    <p class="categoria-id">ID: <?php echo $categoria['id']; ?></p>
                    <p class="categoria-nombre"><?php echo $categoria['nombre']; ?></p>

                    <!-- Botones de acción -->
                    <div class="categoria-acciones">
                        <a href="<?= base_url ?>categoria/editar&id=<?= $categoria['id'] ?>" class="button editar">
                            <button class="button editar">Editar</button>
                        </a>

                        <a href="<?= base_url ?>categoria/eliminar&id=<?= $categoria['id'] ?>" 
                            class="button eliminar">
                            <button class="button eliminar">Eliminar</button>
                        </a>
                    </div>
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