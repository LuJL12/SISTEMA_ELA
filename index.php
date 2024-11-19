<?php
$alert = "";
session_start();

if (!empty($_SESSION['active'])) {
	header('Location: sistema/');
} else {
	if (!empty($_POST)) {
		if (empty($_POST['usuario']) || empty($_POST['pass'])) {
			$alert = 'Todos los campos son necesarios';
		} else {
			require_once 'sistema/includes/database.php';
			$usuario = $_POST['usuario'];
			$pass = $_POST['pass'];

			// Consulta SQL para obtener la información del usuario y su rol.
			$sql = "SELECT u.idUsuario, u.nombreUsuario, u.password, r.idRol, r.descripcionRol, p.nombres, p.apellidos
                        FROM usuario AS u 
                        INNER JOIN rol AS r ON u.idRol = r.idRol
                        INNER JOIN personal AS p ON u.idPersonal= p.idPersonal
                        WHERE u.nombreUsuario = ?";

			$query = $pdo->prepare($sql);
			$query->execute(array($usuario));
			$data = $query->fetch();

			// Verifica si el usuario existe y la contraseña proporcionada coincide con la almacenada en la base de datos.
			if ($data && $pass === $data['password']) {
				// Si la verificación es correcta, se inicia una sesión activa.
				$_SESSION['active'] = true;
				$_SESSION['idUsuario'] = $data['idUsuario'];  // Se almacena el ID del usuario.
				$_SESSION['nombres'] = $data['nombres'];
				$_SESSION['apellidos'] = $data['apellidos'];  // Se almacena el nombre de usuario.
				$_SESSION['rol'] = $data['idRol'];  // Se almacena el ID del rol del usuario.
				$_SESSION['rol_name'] = $data['descripcionRol'];  // Se almacena el nombre del rol.
				$_SESSION['tiempo'] = time();  // Inicializa el tiempo de sesión.

				header("Location: sistema/");
			} else {
				$alert = 'El usuario o la clave son incorrectos';
				session_destroy();
			}
		}
	}
}
?>

<!DOCTYPE html>
<!-- Indica que el documento es de tipo HTML5 -->
<html lang="en">

<head>
	<!-- Define el conjunto de caracteres para el documento -->
	<meta charset="UTF-8">
	<!-- Indica que el documento es compatible con IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Configura la vista para dispositivos móviles -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Establece conexión previa con Google Fonts para mejorar el rendimiento -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<!-- Establece conexión previa con Google Fonts para cargar fuentes -->
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- Importa la fuente 'Quicksand' desde Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
	<!-- Enlaza el archivo de estilos CSS principal -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	<!-- Bootstrap CSS (si no lo tienes ya incluido) -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- Establece el favicon del sitio -->
	<link rel="shortcut icon" type="image/x-icon" href="images/LOGOELA.png">
	<!-- Título de la pestaña del navegador -->
	<title>COLEGIO I.E. ELA</title>

	<!-- Carga de librerías -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="js/scripts/script.js"></script>
</head>

<body>
	<!-- Contenedor para el spinner de carga (se puede utilizar para mostrar un indicador de carga) -->
	<div id='spinner'></div>
	<!-- Incluye mensajes de sistema (probablemente para mostrar errores o alertas) -->

	<!-- Contenedor principal para el contenido del formulario de inicio de sesión -->
	<div class="contenedor">
		<!-- Columna izquierda donde se coloca el formulario -->
		<div class="columna-izquierda">
			<!-- Sección de registro activa -->
			<div class="registro activo" id="registro">
				<div class="header">
					<!-- Título del formulario -->
					<h1>¡Iniciar sesión!</h1>
					<!-- Línea separadora -->
					<p> - - - - - - - - - - - - - - - -</p>
				</div>
				<!-- Formulario para iniciar sesión -->
				<form class="formulario" name="formulario" action="index.php" method="POST" onsubmit="return validateForm()">
					<!-- Etiqueta para el campo de usuario -->
					<label for="nombre">Usuario</label>
					<div class="contenedor-input">
						<!-- Icono de usuario -->
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
							<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
							<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
						</svg>
						<!-- Campo de entrada para el nombre de usuario -->
						<input type="text" name="usuario" id="usuario" required autofocus pattern="[A-Za-z]+" title="Solo se permiten letras">
					</div>

					<!-- Etiqueta para el campo de contraseña -->
					<label for="password">Contraseña</label>
					<div class="contenedor-input" style="display: flex; align-items: center;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
							<path d="M8 1a3 3 0 0 0-3 3v3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1h-1V4a3 3 0 0 0-3-3zm-1 6V4a1 1 0 0 1 2 0v3H7z" />
						</svg>
						<input type="password" name="pass" id="pass" required pattern="[0-9]+" title="Solo se permiten números." style="flex-grow: 1;">
					</div>

					<!-- Contenedor para el botón de inicio de sesión -->
					<div class="contenedor-boton">
						<!-- Botón de envío del formulario -->
						<input type="submit" value="Ingresar" id="btn-login">
					</div>
				</form>
			</div>
		</div>
		<!-- Columna derecha, actualmente vacía -->
		<div class="columna-derecha">
			<!-- Sección de la columna derecha, actualmente vacía -->
		</div>
	</div>
	<script>
		
	</script>
</body>

</html>