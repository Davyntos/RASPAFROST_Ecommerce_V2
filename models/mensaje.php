<?php
// Se incluye el archivo de conexión a la base de datos.
// Este archivo contiene la variable $conexion, utilizada para realizar consultas mediante PDO.
require_once __DIR__ . '/../config/db.php';

// Modelo Mensaje.
// Esta clase se encarga de gestionar los mensajes enviados desde el formulario de contacto.
class Mensaje {

    public static function guardar($nombre, $correo, $asunto, $mensaje) {
        global $conexion;

        $sql = "INSERT INTO mensajes_contacto 
                (nombre, correo, asunto, mensaje)
                VALUES 
                (:nombre, :correo, :asunto, :mensaje)";

        $stmt = $conexion->prepare($sql);

        return $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':asunto' => $asunto,
            ':mensaje' => $mensaje
        ]);
    }

    public static function obtenerTodos() {
        global $conexion;

        $sql = "SELECT * FROM mensajes_contacto ORDER BY fecha DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorId($id) {
        global $conexion;

        $sql = "SELECT * FROM mensajes_contacto WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function responder($id, $respuesta) {
        global $conexion;

        $sql = "UPDATE mensajes_contacto
                SET respuesta = :respuesta,
                    estado = 'respondido'
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);

        return $stmt->execute([
            ':respuesta' => $respuesta,
            ':id' => $id
        ]);
    }

    public static function contarMensajesPendientes() {
        global $conexion;

        $sql = "SELECT COUNT(*) AS total
                FROM mensajes_contacto
                WHERE estado = 'nuevo'";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function contarRespuestasCliente($correo) {
        global $conexion;

        $sql = "SELECT COUNT(*) AS total
                FROM mensajes_contacto
                WHERE correo = :correo
                AND estado = 'respondido'
                AND respuesta IS NOT NULL
                AND respuesta != ''";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':correo' => $correo
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function obtenerMensajesPorCorreo($correo) {
        global $conexion;

        $sql = "SELECT *
                FROM mensajes_contacto
                WHERE correo = :correo
                ORDER BY fecha DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':correo' => $correo
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================================================================
    // 🛡️ PUENTE DE COMPATIBILIDAD PARA EL HEADER DEL BACKOFFICE
    // =========================================================================
    // Redirige la petición que hace tu header antiguo al método correcto actual.
    public static function contarNuevos() {
        return self::contarMensajesPendientes();
    }
}

// 💡 ALIAS GLOBAL:
// Tu 'header.php' busca la clase "Message". Con este alias dinámico de PHP, 
// cuando intente instanciar o llamar a "Message", el sistema usará en su lugar
// esta clase "Mensaje" de forma transparente y sin lanzar errores catastróficos.
if (!class_exists('Message')) {
    class_alias('Mensaje', 'Message');
}
?>