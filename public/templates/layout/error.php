<?php

use Cake\Core\Configure;
?>
<style>
    /* error.css */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        text-align: center;
    }

    .error-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 90%;
    }

    header h1 {
        color: #e74c3c;
        font-size: 2em;
    }

    .error-message h2 {
        font-size: 1.5em;
        color: #333;
        margin-top: 0;
    }

    .error-details {
        background-color: #fdf2f2;
        border: 1px solid #f5c6c6;
        padding: 10px;
        margin-top: 20px;
        text-align: left;
    }

    .btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #2980b9;
    }
</style>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - <?= h($this->fetch('title')) ?></title>
    <?= $this->Html->css('error') ?>
</head>

<body>
    <div class="error-container">
        <header>
            <h1>¡Ups! Algo salió mal.</h1>

        </header>
        <main>
            <div class="error-message">
                <?php if (Configure::read('debug')): ?>
                    <!-- Mostrar código de error y detalles solo en modo depuración -->
                    <div class="error-details">
                        <h3>Detalles del Error:</h3>

                        <p><?php echo($this->fetch('content')) ?></p>
                    </div>
                <?php else: ?>

                    <p> <?php echo $this->fetch('content'); ?></p>
                <?php endif; ?>


            </div>
            <a href="<?= $this->request->referer('/', true) ?>" class="btn">Volver</a>

        </main>
    </div>
</body>

</html>
