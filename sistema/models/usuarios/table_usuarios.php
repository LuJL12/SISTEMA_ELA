<?php
require_once '../../includes/database.php';
header('Content-Type: application/json');

$sql = "SELECT u.idUsuario, p.nombres, p.apellidos, p.dni, p.fechaNac, p.email, p.direccion, p.celular, 
            a.descripcionArea, c.descripcion AS descripcionCargo, u.nombreUsuario, r.descripcionRol, u.status 
        FROM usuario AS u 
        INNER JOIN rol AS r ON u.idRol = r.idRol 
        INNER JOIN personal AS p ON u.idPersonal = p.idPersonal 
        INNER JOIN areas AS a ON p.idArea = a.idArea 
        INNER JOIN cargo AS c ON p.idCargo = c.idCargo
        WHERE u.status != 0";

try {
    $query = $pdo->prepare($sql);
    $query->execute();
    $data = ($query->rowCount() > 0) ? $query->fetchAll(PDO::FETCH_ASSOC) : [];

    foreach ($data as &$usuario) {
        $usuario['status'] = ($usuario['status'] == 1) 
            ? '<span class="badge badge-success">Activo</span>' 
            : '<span class="badge badge-danger">Inactivo</span>';

        $idUsuario = intval($usuario['idUsuario']);
        $usuario['options'] = '
            <div class="text-center">
                <button class="btn btn-primary btn-sm btnEditUser" data-id="' . $idUsuario . '" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="btn btn-danger btn-sm deleteUser" data-id="' . $idUsuario . '" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>';
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'msg' => 'Error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    error_log("Error en table_usuarios.php: " . $e->getMessage());
}

die();
?>
