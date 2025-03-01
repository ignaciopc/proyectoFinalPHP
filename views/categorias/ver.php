<?php if (isset($categoria)): ?>
    <h1><?= $categoria->nombre ?></h1>

    <?php if (empty($productos)): ?>
        <p>No hay productos para mostrar</p>
    <?php else: ?>

        <?php foreach ($productos as $product): ?>
            <div class="product">
                <!-- Enlace al detalle del producto -->
                <a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
                    <div class="image">
                        <?php if ($product->imagen != null): ?>
                            <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
                        <?php else: ?>
                            <img src="<?= base_url ?>assets/img/camiseta.png" />
                        <?php endif; ?>
                    </div>
                    <div class="info">
                        <h2><?= $product->nombre ?></h2>
                        <p><?= $product->precio ?>$</p>
                    </div>
                </a>
                <a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="button">Comprar</a>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
<?php else: ?>
    <h1>La categoría no existe</h1>
<?php endif; ?>
