<?php

/**
 * Cifrado Cesar
 * El cifrado por rotación es un método de cifrado que desplaza cada letra en el texto
 * original un cierto número de posiciones hacia la derecha en el alfabeto. Por ejemplo, si el
 * desplazamiento es 3, la letra 'A' se convierte en 'D', la letra 'B' se convierte en 'E', y así sucesivamente.
 */

require_once 'CesarEncrypt.php';

//TODO: Encriptar.
if (isset($_POST['word']) && isset($_POST['rotation'])) {
   $word      = $_POST['word'];
   $rotation  = $_POST['rotation'];

    $cesarEncrypt = new CesarEncrypt();
    $encrypted = $cesarEncrypt->encrypt($word, $rotation);
}

//TODO: Desencriptar.
$iterationsDecrypted = [];
if (isset($_POST['wordToDecrypt'])) {

    $encrypted = $_POST['wordToDecrypt'];

    $cesarEncrypt = new CesarEncrypt();
    $iterationsDecrypted = $cesarEncrypt->bruteForce($encrypted);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicando Cifrado Cesar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .result span {
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

    </style>
</head>

<body>
<div class="container">
    <h1>Aplicando Cifrado César</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="text" name="word" required value="<?php echo $word ?? '' ?>" placeholder="Escribe la palabra a cifrar">
        <input type="number" name="rotation" value="<?php echo $rotation ?? 3 ?>" placeholder="Desplazamiento">
        <input type="submit" value="Encriptar">
    </form>

    <?php if (isset($encrypted)): ?>
        <div class="result">
            <span>Resultado:</span> <?php echo $encrypted ?>
        </div>
    <?php endif; ?>

    <?php if (isset($encrypted)): ?>
        <div>
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <input type="text" name="wordToDecrypt" required value="<?php echo $encrypted ?>" placeholder="Escribe la palabra a descifrar">
                <input type="submit" value="Descifrar con fuerza bruta">
            </form>
            <?php if (count($iterationsDecrypted) > 0): ?>
                <div class="result">
                    <table>
                        <tr>
                            <th>Iteración</th>
                            <th>Resultado</th>
                            <th>Frecuencia 📉</th>
                        </tr>
                        <?php foreach ($iterationsDecrypted as $wordMetadata): ?>
                            <tr>
                                <td>🠜<?php echo $wordMetadata['position'] ?></td>
                                <td><?php echo $wordMetadata['word'] ?></td>
                                <td><?php echo $wordMetadata['fr'] ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>

</html>
