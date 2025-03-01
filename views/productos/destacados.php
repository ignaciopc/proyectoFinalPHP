<h1>Algunos de nuestros productos</h1>

<?php
// Crear una instancia de la clase Producto
$producto = new Producto();

// Obtener productos aleatorios (ejemplo: 5 productos aleatorios)
$productos = $producto->getRandom(5); // Obtén 5 productos aleatorios

// Verifica si hay productos para mostrar
if ($productos && count($productos) > 0):
    foreach ($productos as $product):
        ?>
        <div class="product">
            <a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
                <?php if ($product->imagen != null): ?>
                    <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
                <?php else: ?>
                    <img src="<?= base_url ?>uploads/images/Captura de pantalla 2024-06-29 013908.png" />
                <?php endif; ?>
                <h2><?= $product->nombre ?></h2>
            </a>
            <p><?= $product->precio ?></p>
            <a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="button">Comprar</a>
        </div>
    <?php
    endforeach;
else:
    echo "<p>No se encontraron productos.</p>";
endif;
?>