<?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete') { ?>
    <strong class="alert_green">Registro completado correctamente</strong>

<?php } elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed') { ?>

    <strong class="alert_reed">Registro Fallido </strong>

<?php } ?>
<?php Utils::deleteSession('register')?>

<h1> Registrarse</h1>
<div class="container">
    <h2>Registro de Usuario</h2>
    <form action="<?= base_url ?>/usuario/save" method="post">
        <input type="text" name="nombre" placeholder="nombre" required>
        <input type="text" name="apellidos" placeholder="apellidos  " required>
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</div>