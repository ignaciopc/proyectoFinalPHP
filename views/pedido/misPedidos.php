<?php if (isset($pedidos) && count($pedidos) > 0): ?>
    <h1>Mis pedidos</h1>
    <table>
        <tr>
            <th>Nº Pedido</th>
            <th>Coste</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($pedidos as $ped): ?>
            <tr>
                <td>
                    <a href="<?= base_url ?>pedido/detalle&id=<?= $ped->id ?>"><?= $ped->id ?></a>
                </td>
                <td>
                    <?= $ped->coste ?> $
                </td>
                <td>
                    <?= $ped->fecha ?>
                </td>
                <td>
                    <?= Utils::showStatus($ped->estado) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No tienes pedidos registrados.</p>
<?php endif; ?>
