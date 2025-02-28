<h1>Gestion de productos</h1>

<div class="categorias-wrapper">
    <?php if (isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
        <strong class="alert_green">El producto se ha creado correctamente</strong>
    <?php elseif (isset($_SESSION['producto']) && $_SESSION['producto'] != 'complete'): ?>
        <strong class="alert_red">El producto NO se ha creado correctamente</strong>
    <?php endif; ?>
    <?php Utils::deleteSession('producto'); ?>

    <?php if (isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
        <strong class="alert_green">El producto se ha borrado correctamente</strong>
    <?php elseif (isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>
        <strong class="alert_red">El producto NO se ha borrado correctamente</strong>
    <?php endif; ?>
    <?php Utils::deleteSession('delete'); ?>
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $product): ?>
            <div class="producto-item">
                <p class="producto-id">ID: <?php echo $product['id']; ?></p>
                <p class="producto-nombre">Nombre:<?php echo $product['nombre']; ?></p>
                <p class="producto-precio">Precio:<?php echo $product['precio']; ?></p>
                <p class="producto-stock">Stock:<?php echo $product['stock']; ?></p>
                <a href="<?= base_url ?>producto/editar&id=<?=$product['id']?>" class="button-editar">Editar</a>
                <a href="<?= base_url ?>producto/eliminar&id=<?=$product['id']?>" class="button-eliminar">Eliminar</a>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay categorías disponibles.</p>
    <?php endif; ?>
</div>

<div class="button-container">
    <a href="<?= base_url ?>producto/crear" class="button">
        <button class="button">Crear Producto</button>
    </a>
</div>