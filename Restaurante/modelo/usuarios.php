<?php
require_once "usuario.php";

$usuario = new Usuario();
$usuarios = $usuario->obtenerUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../CSS/usuarios.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <!-- Formulario crear usuario -->
        <form class="form" method="POST" action="../../controlador/UsuarioController.php">
            <input type="hidden" name="accion" value="crear">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="text" name="telefono" placeholder="Teléfono">
            <select name="rol">
                <option value="Administrador">Administrador</option>
                <option value="Cliente">Cliente</option>
            </select>
            <button type="submit">Añadir Usuario</button>
        </form>

        <!-- Tabla usuarios -->
        <table>
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Acciones</th>
            </tr>
            <?php foreach($usuarios as $u): ?>
            <tr>
                <td><?= $u['id_usuario'] ?></td>
                <td><?= $u['nombre_usuario'] ?></td>
                <td><?= $u['email'] ?></td>
                <td><?= $u['telefono'] ?></td>
                <td><?= $u['rol'] ?></td>
                <td>
                    <!-- Editar -->
                    <form method="POST" action="../../controlador/UsuarioController.php" class="inline">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                        <input type="text" name="nombre" value="<?= $u['nombre_usuario'] ?>">
                        <input type="email" name="email" value="<?= $u['email'] ?>">
                        <input type="text" name="telefono" value="<?= $u['telefono'] ?>">
                        <select name="rol">
                            <option value="Administrador" <?= $u['rol']=="Administrador"?"selected":"" ?>>Administrador</option>
                            <option value="Cliente" <?= $u['rol']=="Cliente"?"selected":"" ?>>Cliente</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>

                    <!-- Eliminar -->
                    <form method="POST" action="../../controlador/UsuarioController.php" class="inline">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                        <button type="submit" class="delete">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
