<h1>Crear nuevos productos</h1>



<div class="form_container">

    <form action="<?= base_url ?>producto/save" method="POST" enctype="multipart/form-data">
        <label for=" nombre">Nombre</label>
        <input type="text" name="nombre" />

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion"></textarea>

        <label for="precio">Precio</label>
        <input type="text" name="precio" />

        <label for="stock">Stock</label>
        <input type="number" name="stock" />

        <label for="categoria">Categoria</label>
        <?php $categorias = Utils::showCategorias(); ?>
        <select name="categoria">
            <?php $categorias = Utils::showCategorias(); ?>
            <?php foreach ($categorias as $categoria): ?>
                <div class="categoria-item">
                    <option value="<?= $categoria['id'] ?>"><?php echo $categoria['nombre']; ?></option>
                </div>
            <?php endforeach; ?>
        </select>

        <label for="imagen">Imagen</label>
        <?php if (isset($pro) && is_object($pro) && !empty($pro->imagen)): ?>
            <img src="<?= base_url ?>uploads/images/<?= $pro->imagen ?>" class="thumb" />
        <?php endif; ?>
        <input type="file" name="imagen" />

        <input type="submit" value="Guardar" />
    </form>
</div>