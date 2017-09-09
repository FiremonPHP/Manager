<?php
namespace FiremonPHP\Manager\Exceptions;


class DuplicateKeyException
{
    /**
     * @var mixed
     */
    private $index;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(string $message, int $code = 11000)
    {
        $cropedMessage = substr($message, strrpos($message,'index:'));
        $this->setValue($cropedMessage);
        $this->setIndex($cropedMessage);
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $message
     */
    private function setValue(string $message)
    {
        $matches = [];
        preg_match('/"(.*?)"/', $message, $matches);
        $this->value = $matches[1];
    }

    /**
     * @param string $message
     */
    private function setIndex(string  $message)
    {
        $matches = [];
        preg_match('/index:\ (.*?)\ /', $message, $matches);
        $this->index = $matches[1];
    }
}