<?php
require_once '../../includes/database.php';
header('Content-Type: application/json');

$idUsuario = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_NUMBER_INT);
$idPersonal = filter_input(INPUT_POST, 'idPersonal', FILTER_SANITIZE_NUMBER_INT);
$nombres = filter_input(INPUT_POST, 'txtNombres', FILTER_SANITIZE_STRING);
$apellidos = filter_input(INPUT_POST, 'txtApellidos', FILTER_SANITIZE_STRING);
$dni = filter_input(INPUT_POST, 'txtDNI', FILTER_SANITIZE_STRING);
$fechaNac = filter_input(INPUT_POST, 'txtFechaNac', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_EMAIL);
$direccion = filter_input(INPUT_POST, 'txtDireccion', FILTER_SANITIZE_STRING);
$celular = filter_input(INPUT_POST, 'txtCelular', FILTER_SANITIZE_STRING);
$area = filter_input(INPUT_POST, 'listArea', FILTER_SANITIZE_STRING);
$cargo = filter_input(INPUT_POST, 'listCargo', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'txtUsuario', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'listStatus', FILTER_SANITIZE_NUMBER_INT);
$rol = filter_input(INPUT_POST, 'listRol', FILTER_SANITIZE_NUMBER_INT);

try {
    $pdo->beginTransaction();

    $queryUsuario = "UPDATE usuario 
                     SET nombreUsuario = :username, status = :status, idRol = :rol 
                     WHERE idUsuario = :idUsuario";
    $stmtUsuario = $pdo->prepare($queryUsuario);
    $stmtUsuario->bindParam(':username', $username);
    $stmtUsuario->bindParam(':status', $status);
    $stmtUsuario->bindParam(':rol', $rol);
    $stmtUsuario->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmtUsuario->execute();

    $queryPersonal = "UPDATE personal 
                      SET nombres = :nombres, apellidos = :apellidos, dni = :dni, 
                          fechaNac = :fechaNac, email = :email, direccion = :direccion, 
                          celular = :celular, idArea = :area, idCargo = :cargo 
                      WHERE idPersonal = :idPersonal";
    $stmtPersonal = $pdo->prepare($queryPersonal);
    $stmtPersonal->bindParam(':nombres', $nombres);
    $stmtPersonal->bindParam(':apellidos', $apellidos);
    $stmtPersonal->bindParam(':dni', $dni);
    $stmtPersonal->bindParam(':fechaNac', $fechaNac);
    $stmtPersonal->bindParam(':email', $email);
    $stmtPersonal->bindParam(':direccion', $direccion);
    $stmtPersonal->bindParam(':celular', $celular);
    $stmtPersonal->bindParam(':area', $area);
    $stmtPersonal->bindParam(':cargo', $cargo);
    $stmtPersonal->bindParam(':idPersonal', $idPersonal, PDO::PARAM_INT);
    $stmtPersonal->execute();

    $pdo->commit();
    echo json_encode(['status' => true, 'msg' => 'Usuario actualizado exitosamente']);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['status' => false, 'msg' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
}
?>