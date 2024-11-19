<?php
require_once '../../includes/database.php';
header('Content-Type: application/json');

// Validar que el idUsuario esté en la solicitud
if (!isset($_POST['idUsuario']) || empty($_POST['idUsuario'])) {
    http_response_code(400);
    echo json_encode(['status' => false, 'msg' => 'ID de usuario inválido o faltante']);
    exit;
}

$idUsuario = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_NUMBER_INT);

try {
    $pdo->beginTransaction();

    // Obtener el idPersonal asociado antes de eliminar el usuario
    $queryGetPersonalId = "SELECT idPersonal FROM usuario WHERE idUsuario = :idUsuario";
    $stmtGetPersonalId = $pdo->prepare($queryGetPersonalId);
    $stmtGetPersonalId->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtGetPersonalId->execute();

    $idPersonal = $stmtGetPersonalId->fetchColumn();

    if (!$idPersonal) {
        throw new Exception('El usuario no tiene un registro asociado en personal o no se encontró.');
    }

    // Eliminar el registro en la tabla usuario
    $queryDeleteUsuario = "DELETE FROM usuario WHERE idUsuario = :idUsuario";
    $stmtDeleteUsuario = $pdo->prepare($queryDeleteUsuario);
    $stmtDeleteUsuario->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtDeleteUsuario->execute();

    // Eliminar el registro en la tabla personal usando el idPersonal asociado
    $queryDeletePersonal = "DELETE FROM personal WHERE idPersonal = :idPersonal";
    $stmtDeletePersonal = $pdo->prepare($queryDeletePersonal);
    $stmtDeletePersonal->bindParam(':idPersonal', $idPersonal, PDO::PARAM_INT);
    $stmtDeletePersonal->execute();

    // Confirmar la transacción
    $pdo->commit();
    echo json_encode(['status' => true, 'msg' => 'Usuario y registro en personal eliminados exitosamente']);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['status' => false, 'msg' => 'Error al eliminar el usuario y el registro de personal: ' . $e->getMessage()]);
}
?>
