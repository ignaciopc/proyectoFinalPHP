<h1 class="pedido-title">Hacer pedido</h1>

<br/>

<h3 class="pedido-direccion-title">Dirección para el envío:</h3>
<form class="pedido-form" action="<?= base_url ?>pedido/add" method="POST">
    <label class="pedido-label" for="provincia">Provincia</label>
    <input class="pedido-input" type="text" name="provincia" required />

    <label class="pedido-label" for="ciudad">Ciudad</label>
    <input class="pedido-input" type="text" name="localidad" required />

    <label class="pedido-label" for="direccion">Dirección</label>
    <input class="pedido-input" type="text" name="direccion" required />

    <input class="pedido-submit" type="submit" value="Confirmar pedido" />
    <p class="pedido-link">
    <a href="<?= base_url ?>carrito/index">Ver los productos y el precio del pedido</a>
</p>
</form>
