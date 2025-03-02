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
				<img src="<?= base_url ?>./public/img/logotipo.avif" alt="Logo de la Frutería" />
			</div>
			<div id="nombre-fruteria">
				Frutas del Valle
			</div>
		</header>



		<!-- MENU -->
		<nav class="menu">
			<ul>
				<li class="categoria-item"><a href="<?= base_url ?>">Inicio</a></li>
				<?php $categorias = Utils::showCategorias(); ?>
				<?php foreach ($categorias as $categoria): ?>
					<li class="categoria-item">
						<a
							href="<?= base_url ?>categoria/ver&id=<?= $categoria['id'] ?>"><?php echo $categoria['nombre']; ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div id="content">
		</div>