<?php
session_start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: contactos/listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AgendaPlus — Gestión de Contactos</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

    <main class="pagina-inicio">

        <section class="contenedor">

            <div class="inicio-contenido">

                <div class="logo">
                    Agenda<span>Plus</span>
                </div>

                <h1>
                    Tu agenda personal,
                    <span>simple y siempre al día.</span>
                </h1>

                <p>
                    Gestiona, organiza y encuentra a tus contactos de forma rápida,
                    eficiente y con total privacidad desde cualquier lugar.
                </p>

                <div class="inicio-botones">
                    <a href="auth/login.php" class="btn btn-principal">
                        Iniciar sesión
                    </a>

                    <a href="auth/registro.php" class="btn btn-secundario">
                        Crear cuenta
                    </a>
                </div>

            </div>

        </section>

    </main>

</body>

</html>
