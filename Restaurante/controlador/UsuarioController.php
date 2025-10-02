<?php
require_once "../configuracion/conexion.php";
require_once "../modelo/usuario.php";

class UsuarioController {
    private $modelusuario;

    public function __construct() {
        $this->modelusuario = new Usuario(); 
    }

    // Login
    public function validarusu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $this->modelusuario->login($_POST['email'], $_POST['password']);

            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: ../vista/view/usuarios.php");
                exit();
            } else {
                header("Location: ../vista/view/login.php?error=1");
                exit();
            }
        }
    }

    // Cerrar sesión
    public function cerrarsesion(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../vista/view/login.php");
        exit();
    }

    // Crear usuario
    public function crear() {
        $this->modelusuario->crearUsuarios($_POST['nombre'], $_POST['email'], $_POST['contrasena'], $_POST['telefono'], $_POST['rol']);
        header("Location: ../vista/view/usuarios.php");
        exit();
    }

    // Actualizar usuario
    public function actualizar() {
        $this->modelusuario->actualizarUsuario($_POST['id_usuario'], $_POST['nombre'], $_POST['email'], $_POST['telefono'], $_POST['rol']);
        header("Location: ../vista/view/usuarios.php");
        exit();
    }

    // Eliminar usuario
    public function eliminar() {
        $this->modelusuario->eliminarUsuario($_POST['id_usuario']);
        header("Location: ../vista/view/usuarios.php");
        exit();
    }
}

// Ejecutar acción
$objeto = new UsuarioController();

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'login': $objeto->validarusu(); break;
        case 'crear': $objeto->crear(); break;
        case 'actualizar': $objeto->actualizar(); break;
        case 'eliminar': $objeto->eliminar(); break;
        case 'cerrar': $objeto->cerrarsesion(); break;
    }
}
?>
