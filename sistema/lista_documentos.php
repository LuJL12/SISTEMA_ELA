<?php
session_start();
if (empty($_SESSION['active'])) {
    header("Location: ../");
}
require_once 'includes/sesion.php';
require_once 'includes/header.php';
require_once 'includes/Modals/modaldocumentos.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>
                <i class="app-menu__icon fa fa-file"></i> Lista de Documentos
                <button class="btn btn-primary" type="button" onclick="openDocumental()">Nuevo</button>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Documentos</li>
            <li class="breadcrumb-item"><a href="#">Lista documentos</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableDocumentos">
                            <thead>
                                <tr>
                                    <th>N_Orden</th>
                                    <th>F_recibido</th>
                                    <th>Asunto</th>
                                    <th>Estado</th>
                                    <th>Dependencia</th>
                                    <th>Cargo</th>
                                    <th>T_Solicitante</th>
                                    <th>T_documento</th>
                                    <th>Área destino</th>
                                    <th>Recepcionista</th>
                                    <th>Archivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>