<?php

/**
 *
 * @author bits.JuanDiaz <juan.diaz@bitsamericas.com>
 * @copyright Copyright (c) 2024, Bits Americas S.A.S
 * @date 3/12/2024
 * @version 1.0.0
 */
class SortByDatamuseApi {

    public function sortByCommonWords(array $words): array {
        $result = [];
        $curl = curl_init();
        foreach ($words as $key => $word) {
            $data = [];
            //verificamos que tenga mas de una palabra, sitiene mas de una palabra, separamos y buscamos la frecuencia de cada una
            $wordsSeparated = explode(' ', $word);


            if(count($wordsSeparated) > 1) {
                $metadataWord = [];
                foreach ($wordsSeparated as $wordSeparated) {
                    $url = "https://api.datamuse.com/words?sp=$wordSeparated&md=fr&max=1&v=es";
                    $metadataWord[] = $this->get($curl, $url)[0] ?? null;
                }

                if (!empty($metadataWord)) {
                    //sumamos el valor de frecuencia de cada palabra de la frase
                    $data[]['tags'][1] = array_reduce(array_filter($metadataWord), function ($acum, $value) {
                        return $acum + filter_var($value['tags'][1], FILTER_SANITIZE_NUMBER_INT);
                    }, 0);

                }

            }else{
                $justWord = $wordsSeparated[0];
                $url = "https://api.datamuse.com/words?sp=$justWord&md=fr&max=1&v=es";
                $data = $this->get($curl, $url);
            }

            $result[] = [
                'word' => $word,
                'position' => $key,
                'fr' => array_map(function ($word) {
                        return (int)filter_var($word['tags'][1], FILTER_SANITIZE_NUMBER_INT);
                    }, $data ?? [])[0] ?? 0,
            ];

        }

        usort($result, function($a, $b) {
            return $b['fr'] - $a['fr']; // Orden descendente por puntuación
        });

        //formateamos a decimal
        array_walk($result, function (&$item, $key) {
            $item['fr'] = number_format($item['fr']);
        });

        return $result;
    }

    private function get($curl, string $url) {
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = json_decode(curl_exec($curl), true);
        return $data;
    }

}