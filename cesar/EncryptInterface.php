<?php

interface EncryptInterface {
    public function encrypt(string $input, int $rotation): string;
    public function decrypt(string $input, int $rotation): string;
    public function bruteForce(string $encrypt): array;

}