<?php if (isset($editar) && isset($prod) && is_object($prod)) {

    ?>
    <h1>Editar producto: <?php echo $prod->nombre ?></h1>



    <?php
    $url = base_url . "producto/save&id=" . $prod->id;

} else {
    ?>
    <h1>Crear nuevos productos</h1>

    <?php
    $url = base_url . "producto/save";

} ?>



<div class="form_container">
    <?php
    ?>
    <form action="<?= $url ?>" method="POST" enctype="multipart/form-data">
        <label for=" nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= isset($prod) && is_object($prod) ? $prod->nombre : ''; ?>" />

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion"><?= isset($prod) && is_object($prod) ? $prod->descripcion : ''; ?></textarea>

        <label for="precio">Precio</label>
        <input type="text" name="precio" value="<?= isset($prod) && is_object($prod) ? $prod->precio : ''; ?>" />

        <label for="stock">Stock</label>
        <input type="number" name="stock" value="<?= isset($prod) && is_object($prod) ? $prod->stock : ''; ?>" />

        <label for="categoria">Categoria</label>
        <?php $categorias = Utils::showCategorias(); ?>
        <select name="categoria">
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= isset($prod) && is_object($prod) && $prod->categoria_id == $categoria['id'] ? 'selected' : ''; ?>>
                    <?= $categoria['nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select>


        <label for="imagen">Imagen</label>
        <?php if (isset($prod) && is_object($prod) && !empty($prod->imagen)): ?>
            <img src="<?= base_url ?>uploads/images/<?= $prod->imagen ?>" class="thumb" />
        <?php endif; ?>
        <input type="file" name="imagen" />

        <input type="submit" value="Guardar" />
    </form>
</div>