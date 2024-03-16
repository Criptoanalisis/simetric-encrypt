<?php

// Función para cifrar un mensaje utilizando RC4
function cifrarRC4($mensaje, $clave) {
    $estado = range(0, 255); //vector de estado

    $x = $y = $index1 = $index2 = 0;
    $result = '';

    // Preparación del estado
    for ($index1 = 0; $index1 < 256; $index1++) {

        $index2 = ($index2 + $estado[$index1] + ord($clave[$index1])) % 256;
        var_dump($clave[$index1]);
        var_dump(ord($clave[$index1]));
        var_dump($estado[$index1], $index1);die;
        // Intercambio de valores
        $temp = $estado[$index1];

        $estado[$index1] = $estado[$index2];
        $estado[$index2] = $temp;
    }


    // Generación del flujo cifrado
    for ($i = 0; $i < strlen($mensaje); $i++) {
        $x = ($x + 1) % 256;
        $y = ($y + $estado[$x]) % 256;
        // Intercambio de valores
        $temp = $estado[$x];
        $estado[$x] = $estado[$y];
        $estado[$y] = $temp;
        // Cifrado del byte
        $result .= $mensaje[$i] ^ chr($estado[($estado[$x] + $estado[$y]) % 256]);
    }

    return $result;
}

// Ejemplo de uso
$mensajeOriginal = "Hola, mundo";
echo "Mensaje original: " . $mensajeOriginal . "\n";

$claveWEP = "clave"; // Clave WEP de ejemplo
$mensajeCifrado = cifrarRC4($mensajeOriginal, $claveWEP);
echo "Mensaje cifrado: " . bin2hex($mensajeCifrado) . "\n";

// Función para descifrar un mensaje cifrado utilizando RC4
function descifrarRC4($mensajeCifrado, $clave) {
    // La operación de descifrado es la misma que el cifrado
    return cifrarRC4($mensajeCifrado, $clave);
}

// Descifrar el mensaje utilizando RC4
$mensajeDescifrado = descifrarRC4($mensajeCifrado, $claveWEP);
echo "Mensaje descifrado: " . $mensajeDescifrado . "\n";