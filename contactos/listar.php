<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/conexion.php";
require_once "../includes/mensajes.php"; 

$sql = "SELECT id, nombre, telefono, correo, ciudad
        FROM contactos
        WHERE id_usuario = ?
        ORDER BY id DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute([$_SESSION["usuario_id"]]);

$contactos = $stmt->fetchAll();

$total_contactos = count($contactos);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis contactos | AgendaPlus</title>

    <link rel="stylesheet" href="../css/estilo.css">

</head>

<body>

    <header class="navbar">

        <div class="contenedor navbar-contenido">

            <a href="listar.php" class="navbar-logo">
                Agenda<span>Plus</span>
            </a>

            <div class="navbar-usuario">

                <span>
                    <?= htmlspecialchars($_SESSION["usuario_nombre"]) ?>
                </span>

                <a href="../auth/logout.php">
                    Cerrar sesión
                </a>

            </div>

        </div>

    </header>

    <main class="contenedor dashboard">
        
        <?php mostrarMensaje(); ?>

        <div class="dashboard-cabecera">

            <div>

                <p class="dashboard-saludo">
                    Panel de control
                </p>

                <h1>
                    Bienvenido, <?= htmlspecialchars($_SESSION["usuario_nombre"]) ?>
                </h1>

                <div class="dashboard-correo">
                    <span>Correo:</span> <?= htmlspecialchars($_SESSION["usuario_correo"] ?? "") ?>
                </div>

                <p>
                    Consulta, administra y organiza todos tus contactos personales.
                </p>

            </div>

            <a
                href="crear.php"
                class="btn btn-principal">
                + Nuevo contacto
            </a>

        </div>

        <section class="estadisticas">

            <div class="estadistica-card">

                <div>

                    <p>
                        Contactos registrados
                    </p>

                    <strong>
                        <?= $total_contactos ?>
                    </strong>

                </div>

            </div>

        </section>

        <section class="contactos-seccion">

            <div class="seccion-cabecera">

                <div>

                    <h2>
                        Directorio de Contactos
                    </h2>

                    <p>
                        Listado completo de personas registradas en tu cuenta.
                    </p>

                </div>

            </div>

            <?php if (empty($contactos)): ?>

                <div class="estado-vacio">

                    <h3>
                        Aún no tienes contactos guardados
                    </h3>

                    <p>
                        Agrega personas para verlas organizadas en tu directorio.
                    </p>

                    <a
                        href="crear.php"
                        class="btn btn-principal">
                        Agregar primer contacto
                    </a>

                </div>

            <?php else: ?>

                <div class="tabla-contenedor">

                    <table class="tabla-contactos">

                        <thead>

                            <tr>

                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Ciudad</th>
                                <th>Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($contactos as $contacto): ?>

                                <tr>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars(
                                                $contacto["nombre"],
                                                ENT_QUOTES, 
                                                "UTF-8"
                                            ) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($contacto["telefono"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($contacto["correo"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($contacto["ciudad"]) ?>
                                    </td>

                                    <td class="acciones">

                                        <a
                                            href="editar.php?id=<?= (int)$contacto["id"] ?>"
                                            class="accion-editar">
                                            Editar
                                        </a>

                                        <form action="eliminar.php" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contacto?');"
                                            style="display:inline;">

                                            <input type="hidden" name="id" value="<?= (int)$contacto["id"] ?>">
                                            
                                            <button type="submit" class="accion-eliminar">
                                                Eliminar
                                            </button> 

                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </section>

    </main>

</body>

</html>
