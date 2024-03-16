<?php

require_once 'EncryptInterface.php';
require_once 'SortByDatamuseApi.php';

/**
 *
 * @author bits.JuanDiaz <juan.diaz@bitsamericas.com>
 * @copyright Copyright (c) 2024, Bits Americas S.A.S
 * @date 3/9/2024
 * @version 1.0.0
 */
class CesarEncrypt implements EncryptInterface {
    private array $abcedario;
    private int $countAbcededario;

    public function __construct() {
        //Se utiliza un array que representa el alfabeto inglés 26 letras
        $this->abcedario       = range('A', 'Z');
        $this->countAbcededario = count($this->abcedario); //26
    }

    public function encrypt(string $input, int $rotation): string {

        if (empty($input)) {
           throw new Exception('El texto no puede estar vacio.');
        }

        $input = trim($input); //El texto se normaliza para eliminar espacios al principio y al final
        $input = strtoupper($input); //pone en mayuscula todo
        $lengthText = strlen($input); //cuenta el numero de letras

        $resolved = '';

        /**
         * El bucle recorre cada letra del texto y cifra la letra según el desplazamiento especificado.
         * Se utiliza la función array_search()
         * para encontrar la posición de la letra en el alfabeto y luego se realiza el desplazamiento.
         */
        for ($i = 0; $i < $lengthText; $i++) {
            $letter = $input[$i];

            //posicion en el abecedario, sino encuentra devuelve false.
            $positionInAbc = array_search($letter, $this->abcedario);

            if($positionInAbc !== false) {
                //posicion + rotacion / modulo de la division.
                $newPosition = ($positionInAbc + $rotation) % $this->countAbcededario;
                $currentLetter = $this->abcedario[$newPosition]; //M
            }else {
                $currentLetter = $letter; //solo concatenamos.
            }

            $resolved .= $currentLetter;
        }

        return $resolved;
    }

    public function decrypt(string $input, int $rotation): string {

        if (empty($input)) {
            throw new Exception('El texto no puede estar vacio.');
        }

        $input = trim($input); //El texto se normaliza para eliminar espacios al principio y al final
        $input = strtoupper($input); //pone en mayuscula todo
        $lengthText = strlen($input); //cuenta el numero de letras

        $resolved = '';

        /**
         * El bucle recorre cada letra del texto y cifra la letra según el desplazamiento especificado.
         * Se utiliza la función array_search()
         * para encontrar la posición de la letra en el alfabeto y luego se realiza el desplazamiento.
         */
        for ($i = 0; $i < $lengthText; $i++) {
            $letter = $input[$i];

            //posicion en el abecedario, sino encuentra devuelve false.
            $positionInAbc = array_search($letter, $this->abcedario);

            if($positionInAbc !== false) {
                $newPosition = ($positionInAbc - $rotation + 26) % $this->countAbcededario;
                $currentLetter = $this->abcedario[$newPosition];
            }else {
                $currentLetter = $letter;
            }

            $resolved .= $currentLetter;
        }

        return $resolved;
    }

    /**
     * Dado que el cifrado César tiene un espacio de claves muy pequeño
     * (solo 26 posibles desplazamientos en el alfabeto inglés)
     */
    public function bruteForce(string $encrypt): array {
        $i = 1;

        $results = [];

        while($i <= $this->countAbcededario) {
            $results[$i] = $this->decrypt($encrypt, $i);
            $i++;
        }

        $sort = new SortByDatamuseApi();
        $results = $sort->sortByCommonWords($results);

        return $results;
    }




}