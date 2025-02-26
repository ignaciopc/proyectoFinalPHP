<h1> Registrarse</h1>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="index.php?controller=usuario&action=guardar" method="post">
            <input type="text" name="nombre" placeholder="nombre" required>
            <input type="text" name="apellidos" placeholder="apellidos  " required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
    </div>
