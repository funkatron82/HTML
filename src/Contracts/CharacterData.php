<?php
namespace CEC\HTML\Contracts;

interface CharacterData
{
    public function appendData(string $data);

    public function deleteData(int $offset);

    public function insertData(int $offset, string $data);

    public function replaceData(int $offset, int $length, string $data);

    public function substringData(int $offset, int $length): string;

    public function length(): int;
}
