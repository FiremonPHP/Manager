<?php
namespace FiremonPHP\Manager\Queries;


class InsertQuery
{
    public function __construct(array $data, \MongoDB\Driver\BulkWrite $bulk)
    {
        $bulk->insert($data);
    }
}