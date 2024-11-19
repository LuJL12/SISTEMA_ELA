<?php
require_once '../../includes/database.php';

try {
    // Verificar que la solicitud sea POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status" => false,
            "msg" => "Método HTTP no válido. Método actual: " . ($_SERVER['REQUEST_METHOD'] ?? 'undefined')
        ]);
        exit;
    }

    // Lista de campos requeridos
    $requiredFields = [
        'txtNombres', 'txtApellidos', 'txtDNI', 'txtEmail',
        'txtCelular', 'listArea', 'listCargo', 'txtUsuario',
        'listRol', 'listStatus'
    ];

    // Validar campos requeridos
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => false, 'msg' => 'Todos los campos son necesarios']);
            exit;
        }
    }

    // Asignación de variables desde POST con sanitización básica
    $idUsuario   = isset($_POST['idUsuario']) ? intval($_POST['idUsuario']) : 0;
    $nombres     = htmlspecialchars(trim($_POST['txtNombres']));
    $apellidos   = htmlspecialchars(trim($_POST['txtApellidos']));
    $dni         = htmlspecialchars(trim($_POST['txtDNI']));
    $fechaNac    = htmlspecialchars(trim($_POST['txtFechaNac']));
    $email       = filter_var(trim($_POST['txtEmail']), FILTER_VALIDATE_EMAIL);
    $direccion   = htmlspecialchars(trim($_POST['txtDireccion']));
    $celular     = htmlspecialchars(trim($_POST['txtCelular']));
    $area        = intval($_POST['listArea']);
    $cargo       = intval($_POST['listCargo']);
    $usuario     = htmlspecialchars(trim($_POST['txtUsuario']));
    $clave       = isset($_POST['clave']) ? $_POST['clave'] : '';
    $rol         = intval($_POST['listRol']);
    $status      = intval($_POST['listStatus']);

    // Validar el correo electrónico
    if (!$email) {
        echo json_encode(['status' => false, 'msg' => 'Correo electrónico no válido']);
        exit;
    }

    // Opcional: Validar la contraseña (ejemplo: al menos 8 caracteres)
    if (!empty($clave) && strlen($clave) < 8) {
        echo json_encode(['status' => false, 'msg' => 'La contraseña debe tener al menos 8 caracteres']);
        exit;
    }

    // Almacenar la contraseña sin encriptar
    $pass = !empty($clave) ? $clave : null;

    // Inicia la transacción para asegurarse de que ambas inserciones sean consistentes
    $pdo->beginTransaction();

    if ($idUsuario == 0) {  // Crear nuevo usuario
        // Insertar en la tabla personal
        $sql_insert_personal = "INSERT INTO personal (nombres, apellidos, dni, fechaNac, email, direccion, celular, idArea, idCargo) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql_insert_personal);
        $stmt->execute([
            $nombres, $apellidos, $dni, $fechaNac,
            $email, $direccion, $celular, $area, $cargo
        ]);
        $idPersonal = $pdo->lastInsertId();

        // Insertar en la tabla usuario
        $sql_insert_usuario = "INSERT INTO usuario (nombreUsuario, password, status, idRol, idPersonal) 
                               VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql_insert_usuario);
        $stmt->execute([
            $usuario, $pass, $status, $rol, $idPersonal
        ]);

        $option = 1;
    } else {  // Actualizar usuario existente y sus datos en personal
        // Actualizar en la tabla personal
        $sql_update_personal = "UPDATE personal SET 
                                    nombres = ?, 
                                    apellidos = ?, 
                                    dni = ?, 
                                    fechaNac = ?, 
                                    email = ?, 
                                    direccion = ?, 
                                    celular = ?, 
                                    idArea = ?, 
                                    idCargo = ? 
                                WHERE idPersonal = ?";
        $stmt = $pdo->prepare($sql_update_personal);
        $stmt->execute([
            $nombres, $apellidos, $dni, $fechaNac,
            $email, $direccion, $celular, $area, $cargo, $idUsuario
        ]);

        // Actualizar en la tabla usuario
        if (empty($clave)) {  // Sin cambio de contraseña
            $sql_update_usuario = "UPDATE usuario SET 
                                        nombreUsuario = ?, 
                                        status = ?, 
                                        idRol = ? 
                                    WHERE idUsuario = ?";
            $stmt = $pdo->prepare($sql_update_usuario);
            $stmt->execute([
                $usuario, $status, $rol, $idUsuario
            ]);
        } else {  // Con cambio de contraseña
            $sql_update_usuario = "UPDATE usuario SET 
                                        nombreUsuario = ?, 
                                        password = ?, 
                                        status = ?, 
                                        idRol = ? 
                                    WHERE idUsuario = ?";
            $stmt = $pdo->prepare($sql_update_usuario);
            $stmt->execute([
                $usuario, $pass, $status, $rol, $idUsuario
            ]);
        }

        $option = 2;
    }

    // Confirmar transacción si todo va bien
    $pdo->commit();

    // Respuesta de éxito
    $arrResponse = [
        'status' => true,
        'msg' => ($option == 1) ? 'Usuario creado correctamente' : 'Usuario actualizado correctamente'
    ];
} catch (Exception $e) {
    // Revertir transacción en caso de error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $arrResponse = ['status' => false, 'msg' => 'Error: ' . $e->getMessage()];
}

// Devolver respuesta en formato JSON
echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
exit;
?>
