<?php
// controllers/MensajeController.php

require_once __DIR__ . '/../models/Mensaje.php';

class MensajeController {

    /**
     * Filtro de seguridad privado para asegurar que solo los usuarios 
     * con rol de 'admin' puedan acceder a las funciones del Backoffice.
     */
    private function validarAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: index.php?accion=login");
            exit;
        }
    }

    /**
     * Muestra la interfaz pública para el formulario de contacto.
     */
    public function contacto() {
        require __DIR__ . '/../views/contacto.php';
    }

    /**
     * Procesa y valida el envío del formulario de contacto que manda un cliente.
     */
    public function guardarMensaje() {
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $asunto = trim($_POST['asunto'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');

        // Validación estricta de campos vacíos
        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: index.php?accion=contacto");
            exit;
        }

        // Llamada al método estático del Modelo para insertar en la BD
        Mensaje::guardar($nombre, $correo, $asunto, $mensaje);

        header("Location: index.php?accion=mensaje_enviado");
        exit;
    }

    /**
     * Muestra la pantalla de confirmación exitosa tras enviar un mensaje.
     */
    public function mensajeEnviado() {
        require __DIR__ . '/../views/mensaje_enviado.php';
    }

    /**
     * Backoffice: Lista todos los mensajes de soporte recibidos en el panel de administración.
     * Sincronizado con: index.php?accion=admin_mensajes
     */
    public function adminMensajes() {
        $this->validarAdmin();

        // Recupera todos los mensajes almacenados en la BD
        $mensajes = Mensaje::obtenerTodos();

        require __DIR__ . '/../views/admin/mensajes.php';
    }

    /**
     * Backoffice: Muestra el formulario específico para responder a un mensaje por ID.
     * Sincronizado con: index.php?accion=admin_responder_mensaje&id=X
     */
    public function responderMensaje($id) {
        $this->validarAdmin();

        $mensaje = Mensaje::obtenerPorId($id);

        if (!$mensaje) {
            die("Mensaje no encontrado.");
        }

        // Carga la interfaz para redactar la respuesta
        require __DIR__ . '/../views/admin/responder_mensaje.php';
    }

    /**
     * Backoffice: Procesa y almacena la respuesta redactada por el administrador.
     * Sincronizado con: index.php?accion=admin_guardar_respuesta
     */
    public function guardarRespuesta() {
        $this->validarAdmin();

        $id = $_POST['id'] ?? null;
        $respuesta = trim($_POST['respuesta'] ?? '');

        if (empty($id) || empty($respuesta)) {
            header("Location: index.php?accion=admin_mensajes");
            exit;
        }

        // Ejecuta la actualización o inserción de la respuesta en el Modelo
        Mensaje::responder($id, $respuesta);

        header("Location: index.php?accion=admin_mensajes");
        exit;
    }

    /**
     * Perfil de Usuario: Permite a un cliente logueado auditar las respuestas a sus dudas.
     */
    public function misMensajes() {
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        // Obtiene el historial filtrando por el correo de la sesión activa
        $mensajes = Mensaje::obtenerMensajesPorCorreo(
            $_SESSION['usuario']['email']
        );

        require __DIR__ . '/../views/mis_mensajes.php';
    }
}
?>