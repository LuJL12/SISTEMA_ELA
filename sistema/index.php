<?php
session_start();
if (empty($_SESSION['active'])) {
    header("Location: ../");
}
require_once 'includes/sesion.php';
require_once 'includes/header.php';
?>

<!-- Parte de centro de dashboard -->
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="app-menu__icon fa fa-school"></i> &nbsp; Bienvenido(as) - Sistema de Registro</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="app-menu__icon fa fa-school"></i></li>
            <li class="breadcrumb-item"><a href="">Inicio</a></li>
        </ul>
    </div>
    <img src="images/frontis.png" alt="Imagen de bienvenida" style="width: 100%; max-width: 900px; height: auto; margin: 10px auto; border-radius: 8px; display: block;">
    <div class="row">
        <div class="col-md-6 col-lg-3 card-background">
            <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                <div class="info">
                    <h4><a href="lista_usuarios.php">Usuarios</a></h4>
                    <p><b id="userCount">0</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 card-background">
            <div class="widget-small info coloured-icon"><i class="icon bi bi-heart fs-1"></i>
                <div class="info">
                    <h4><a href="lista_documentos.php">Documentos</a></h4>
                    <p><b>0</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 card-background">
            <div class="widget-small warning coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>
                <div class="info">
                    <h4><a href="lista_actas.php">Actas</a></h4>
                    <p><b>0</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 card-background">
            <div class="widget-small danger coloured-icon"><i class="icon bi bi-star fs-1"></i>
                <div class="info">
                    <h4><a href="lista_actas.php">A. Aplazadas</a></h4>
                    <p><b></b></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>