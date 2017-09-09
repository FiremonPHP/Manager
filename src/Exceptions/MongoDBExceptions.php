<?php
namespace FiremonPHP\Manager\Exceptions;

class MongoDBExceptions
{
    private static $exception_class = [
        11000 => '\\FiremonPHP\\Manager\\Exceptions\\DuplicateKeyException'
    ];

    /**
     * @param \MongoDB\Driver\WriteResult $writeResult
     * @return array
     */
    public static function get(\MongoDB\Driver\WriteResult $writeResult)
    {
        $errors = [];
        array_map(function(\MongoDB\Driver\WriteError $error) use(&$errors){
            $errors[] = new self::$exception_class[$error->getCode()]($error->getMessage());
        }, $writeResult->getWriteErrors());
        return $errors;
    }
}