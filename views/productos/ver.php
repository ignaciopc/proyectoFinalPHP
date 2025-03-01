<?php
// Verificamos si la variable $_GET['id'] está definida para obtener el producto
if (isset($_GET['id'])) {
    $producto = new Producto();
    $producto->setId($_GET['id']);  // Establecemos el ID del producto
    $product = $producto->getOne(); // Obtenemos el producto usando el método getOne()
}
?>

<?php if (isset($product) && $product): ?>
    <h1><?= $product->nombre ?></h1>
    <div id="detail-product">
        <div class="image">
            <?php if ($product->imagen != null): ?>
                <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
            <?php else: ?>
                <img src="<?= base_url ?>assets/img/camiseta.png" />
            <?php endif; ?>
        </div>
        <div class="data">
            <p class="description"><?= $product->descripcion ?></p>
            <p class="price"><?= $product->precio ?>$</p>
            <a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="button">Comprar</a>
        </div>
    </div>
<?php else: ?>
    <h1>El producto no existe</h1>
<?php endif; ?>
