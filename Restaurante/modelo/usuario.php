<?php
require_once "../configuracion/conexion.php"; 

class Usuario {
    private $db;

    public function __construct(){
        $this->db = Database::connect(); 
    }

    // Obtener un usuario por email
    public function obtenerUsuario($email){
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $consul = $this->db->prepare($sql);
        $consul->execute([":email" => $email]);

        return $consul->fetch(PDO::FETCH_ASSOC);
    }

    // Login
    public function login($email, $pass){
        $usuario = $this->obtenerUsuario($email);
        if($usuario && password_verify($pass, $usuario['contrasena'])){
            return $usuario;
        }
        return false;
    }

    // Crear usuario
    public function crearUsuarios($nombre_usuario, $email, $contrasena, $telefono, $rol){
        $hash = password_hash($contrasena, PASSWORD_BCRYPT);
        $sql= "INSERT INTO usuarios(nombre_usuario, email, contrasena, telefono, rol) 
               VALUES (:nombre, :email, :contrasena, :telefono, :rol)";
        $consul = $this->db->prepare($sql);
        return $consul->execute([
            ":nombre" => $nombre_usuario,
            ":email" => $email,
            ":contrasena" => $hash, 
            ":telefono" => $telefono,
            ":rol" => $rol
        ]);
    }

    // Listar todos los usuarios
    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario
    public function actualizarUsuario($id, $nombre, $email, $telefono, $rol) {
        $sql = "UPDATE usuarios SET nombre_usuario=?, email=?, telefono=?, rol=? 
                WHERE id_usuario=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono, $rol, $id]);
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
