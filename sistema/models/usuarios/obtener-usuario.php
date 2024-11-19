<?php
require_once '../../includes/database.php';
header('Content-Type: application/json');

$idUsuario = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$idUsuario) {
    echo json_encode(['status' => false, 'msg' => 'ID de usuario inválido']);
    exit;
}

try {
    $query = "SELECT u.idUsuario, u.nombreUsuario, u.status, u.idRol AS rol, 
                     p.idPersonal, p.nombres, p.apellidos, p.dni, p.fechaNac, 
                     p.email, p.direccion, p.celular, a.descripcionArea, c.descripcion AS descripcionCargo
              FROM usuario AS u
              INNER JOIN personal AS p ON u.idPersonal = p.idPersonal
              INNER JOIN areas AS a ON p.idArea = a.idArea
              INNER JOIN cargo AS c ON p.idCargo = c.idCargo
              WHERE u.idUsuario = :idUsuario";
              
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => true, 'data' => $usuario]);
    } else {
        echo json_encode(['status' => false, 'msg' => 'Usuario no encontrado']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => false, 'msg' => 'Error al obtener los datos']);
}
?>
