<?php



function descifrarCodigo($codigo) {
    $codigo_correcto = "00000111"; // Cambia esto al código que desees descifrar

    // Verifica si el código proporcionado coincide con el código correcto
    return $codigo === $codigo_correcto;

}

$start_time = microtime(true);
/*
 *
 * Las combinaciones posibles de un código de 8 dígitos van desde 00000000 hasta 99999999, lo que totaliza 100,000,000 cien millones combinaciones
 */
// Prueba todas las combinaciones de códigos de 8 dígitos
for ($i = 0; $i < 100000000; $i++) {

    //sino tiene 8 digitos agrega: 0
    $codigo = str_pad($i, 8, "0", STR_PAD_LEFT); // Asegura que el código tenga 8 dígitos

    //00000001
    $resultado = descifrarCodigo($codigo);

    if ($resultado) {
        echo "¡Código descifrado! El código es: $codigo" . PHP_EOL;
        break;
    }

}

$end_time = microtime(true);

// Calculate script execution time
$execution_time = ($end_time - $start_time);
echo('time executed: ' . $execution_time);