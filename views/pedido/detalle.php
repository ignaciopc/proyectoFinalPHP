<h1>Detalle del pedido</h1>

<?php if (isset($pedido)): ?>
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true): ?>
        <!-- Asegúrate de que el usuario tiene el rol de admin -->
        <h3>Cambiar estado del pedido</h3>
        <form action="<?= base_url ?>pedido/estado" method="POST">
            <input type="hidden" value="<?= $pedidoDetails->id ?>" name="pedido_id" />
            <select name="estado">
                <option value="confirm" <?= $pedidoDetails->estado == "confirm" ? 'selected' : ''; ?>>Pendiente</option>
                <option value="preparation" <?= $pedidoDetails->estado == "preparation" ? 'selected' : ''; ?>>En preparación
                </option>
                <option value="ready" <?= $pedidoDetails->estado == "ready" ? 'selected' : ''; ?>>Preparado para enviar</option>
                <option value="sended" <?= $pedidoDetails->estado == "sended" ? 'selected' : ''; ?>>Enviado</option>
            </select>
            <input type="submit" value="Cambiar estado" />
        </form>

        <br />
    <?php endif; ?>

    <table>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Unidades</th>
        </tr>

        <?php if (!empty($productos)): ?> <!-- Asegúrate de que hay productos -->
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td>
                        <?php if ($producto->imagen != null): ?>
                            <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" />
                        <?php else: ?>
                            <img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" />
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
                    </td>
                    <td>
                        <?= $producto->precio ?>
                    </td>
                    <td>
                        <?= $producto->unidades ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay productos en este pedido.</td>
            </tr>
        <?php endif; ?>
    </table>

<?php endif; ?>