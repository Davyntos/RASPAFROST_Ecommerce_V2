<?php
// Se incluye el archivo de conexión a la base de datos.
// Este archivo contiene la variable $conexion, utilizada para realizar consultas mediante PDO.
require_once __DIR__ . '/../config/db.php';

// Modelo Usuario.
// Esta clase se encarga de gestionar las operaciones relacionadas con los usuarios,
// como registrar nuevos usuarios y buscar usuarios por correo electrónico.
class Usuario {

    // Método estático encargado de registrar un nuevo usuario en la base de datos.
    // Recibe como parámetros el nombre, correo electrónico y contraseña del usuario.
    public static function registrar($nombre, $email, $password) {

        // Se utiliza la conexión global definida en el archivo db.php.
        global $conexion;

        // Se encripta la contraseña antes de guardarla en la base de datos.
        // PASSWORD_DEFAULT utiliza el algoritmo recomendado por PHP.
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Consulta SQL para insertar un nuevo usuario.
        // Se guardan el nombre, correo electrónico y la contraseña encriptada.
        $sql = "INSERT INTO usuarios (nombre, email, password) 
                VALUES (:nombre, :email, :password)";

        // Se prepara la consulta para evitar inyecciones SQL.
        $stmt = $conexion->prepare($sql);

        // Se enlazan los valores recibidos con los parámetros de la consulta.
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        // Se ejecuta la consulta.
        return $stmt->execute();
    }

    // Método estático encargado de buscar un usuario por su correo electrónico.
    // Se utiliza principalmente durante el inicio de sesión.
    public static function buscarPorEmail($email) {

        // Se utiliza la conexión global a la base de datos.
        global $conexion;

        // Consulta SQL para obtener la información de un usuario activo
        // a partir de su correo electrónico.
        $sql = "SELECT * FROM usuarios 
                WHERE email = :email AND estado = 'activo'";

        // Se prepara la consulta SQL.
        $stmt = $conexion->prepare($sql);

        // Se enlaza el correo electrónico recibido con el parámetro :email.
        $stmt->bindParam(':email', $email);

        // Se ejecuta la consulta.
        $stmt->execute();

        // Se devuelve el usuario encontrado como arreglo asociativo.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================================================================
    // 👥 MÉTODOS NUEVOS: CONTROLADOR ADMINISTRATIVO Y DASHBOARD (PASO 3)
    // =========================================================================

    // Método estático encargado de contar cuántos usuarios tienen el rol de cliente.
    // Se utiliza para mostrar la métrica en tiempo real en el Dashboard del Administrador.
    public static function contarClientes() {

        // Se utiliza la conexión global a la base de datos.
        global $conexion;

        // Consulta SQL para contar únicamente los usuarios cuyo rol sea 'cliente'.
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'";

        // Se prepara la consulta SQL.
        $stmt = $conexion->prepare($sql);

        // Se ejecuta la consulta.
        $stmt->execute();

        // Se recupera el resultado del conteo.
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna el número total de clientes o 0 si no hay registros.
        return $resultado['total'] ?? 0;
    }

    // Método estático encargado de obtener la lista de todos los clientes registrados.
    // Se utiliza para alimentar la vista de administración (views/admin/clientes.php).
    public static function obtenerClientesAdmin() {

        // Se utiliza la conexión global a la base de datos.
        global $conexion;

        // Consulta SQL para seleccionar los datos esenciales de los clientes.
        // Se ordenan por ID de forma descendente para ver primero los registros más recientes.
        $sql = "SELECT id, nombre, email, rol FROM usuarios WHERE rol = 'cliente' ORDER BY id DESC";

        // Se prepara la consulta SQL.
        $stmt = $conexion->prepare($sql);

        // Se ejecuta la consulta.
        $stmt->execute();

        // Se devuelven todos los clientes encontrados en forma de arreglo asociativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>