<?php
namespace CEC\HTML;

trait CharacterDataBehavior
{
    protected $data = '';

    public function appendData(string $data)
    {
        $this->data .= htmlspecialchars((string) $data, ENT_COMPAT | ENT_HTML5);
    }

    public function deleteData(int $offset)
    {
        $this->data = substr_replace($this->data, '', $offset);
    }

    public function insertData(int $offset, string $data)
    {
        $data = htmlspecialchars((string) $data, ENT_COMPAT | ENT_HTML5);
        $this->data = substr_replace($this->data, $data, $offset, 0);
    }

    public function replaceData(int $offset, int $length, string $data)
    {
        $data = htmlspecialchars((string) $data, ENT_COMPAT | ENT_HTML5);
        $this->data = substr_replace($this->data, $data, $offset, $length);
    }

    public function substringData(int $offset, int $length): string
    {
        return substr($this->data, $offset, $length);
    }

    public function length(): int
    {
        return strlen($this->data);
    }
}
