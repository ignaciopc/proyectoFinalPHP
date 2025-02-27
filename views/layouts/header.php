<?php require_once 'config/parameters.php'; ?>
<!DOCTYPE HTML>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>Tienda de Camisetas</title>
	<link rel="stylesheet" href="<?= base_url ?>./public/css/styles.css" />
</head>

<body>
	<div id="container">
		<!-- CABECERA -->
		<header id="header">
			<div id="logo">
				<img src="<?= base_url ?>./public/img/logotipo.avif" alt="Camiseta Logo" />
				<a href="public/index.php">
			</div>
		</header>

		<!-- MENU -->
		<nav class="menu">
			<ul>
				<?php $categorias = Utils::showCategorias(); ?>
				<?php foreach ($categorias as $categoria): ?>
					<div class="categoria-item">
						<li> <a href=""><?php echo $categoria['nombre']; ?></a></li>
					</div>
				<?php endforeach; ?>
			</ul>
		</nav>
		<div id="content">
		</div>