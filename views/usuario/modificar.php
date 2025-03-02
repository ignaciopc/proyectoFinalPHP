<h1>Modificar cuenta</h1>

<?php if (isset($_SESSION['update_error'])): ?>
    <div class="error">
        <ul>
            <?php foreach ($_SESSION['update_error'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['update_success'])): ?>
    <div class="success">
        <p><?= $_SESSION['update_success'] ?></p>
    </div>
<?php endif; ?>

<!-- Formulario con la clase 'modificar-cuenta-form' -->
<form action="<?= base_url ?>usuario/modificar" method="POST" class="modificar-cuenta-form">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= $_SESSION['identity']->nombre ?>" required />

    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?= $_SESSION['identity']->apellidos ?>" required />

    <label for="email">Correo electrónico</label>
    <input type="email" name="email" value="<?= $_SESSION['identity']->email ?>" required />

    <input type="submit" value="Guardar cambios" />
</form>
