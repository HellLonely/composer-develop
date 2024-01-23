<?php

$config = parse_ini_file('.'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.ini', true);

try {
    $conexion = new PDO(
        'mysql:host=' . $config['database']['hostname'] . ';port=' . $config['database']['puerto'] . ';dbname=' . $config['database']['base_de_datos'],
        $config['database']['usuario'],
        $config['database']['contrasena']
    );

    $consulta = $conexion->query('SELECT VERSION() as version');
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $mariaDbVersion = $resultado['version'];
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}



require 'vendor/phpmailer/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\SMTP;
$smtpVersion = SMTP::VERSION;

$jsonComposerContent = file_get_contents('composer.json');
$dataComposer = json_decode($jsonComposerContent, true);
$requireValues = $dataComposer['require'];
$requireValuesDev = $dataComposer['require-dev'];
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mi Página con Bootstrap</title>

    <?php
        echo '<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">';
    ?>
</head>
<body>

<div class="p-4" style="margin-top: 150px;">
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-large">PHP Development</h2>
        <hr class="w-25">
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center">
        <p class="bg-primary p-2 text-white rounded">
            <?php echo 'PHP Version: '.phpversion()?>
        </p>

        <p class="bg-primary p-2 text-white rounded">
            <?php echo 'Puerto de acceso: '. $_SERVER['SERVER_PORT']?>
        </p>

        <p class="bg-primary p-2 text-white rounded">
            <?php echo 'DB Version: '. $mariaDbVersion?>
        </p>

        <p class="bg-primary p-2 text-white rounded">
            <?php echo 'PHPMailer SMTP Version: '. $smtpVersion?>
        </p>

        <p class="bg-primary p-2 text-white rounded">
            <?php echo 'Bootstrap Version: '. $requireValues['twbs/bootstrap']?>
        </p>

        <p class="bg-primary p-2 text-white rounded">
            <?php echo 'PHPUnit Version: '. $requireValuesDev['phpunit/phpunit']?>
        </p>
    </div>

</div>
</body>
<?php
echo '<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>';
?>
</html>
