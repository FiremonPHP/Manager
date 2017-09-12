<?php
namespace FiremonPHP\Manager;

use FiremonPHP\Manager\Queries\DeleteQuery;
use FiremonPHP\Manager\Queries\FindQuery;
use FiremonPHP\Manager\Queries\InsertQuery;
use FiremonPHP\Manager\Queries\UpdateQuery;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
use MongoDB\Driver\WriteResult;

class Manager
{
    /**
     * @var \MongoDB\Driver\Manager
     */
    private $_manager;

    /**
     * @var string
     */
    private $_alias;

    /**
     * @var \MongoDB\Driver\BulkWrite[]
     */
    private $_bulks = [];

    /**
     * @var WriteResult[]
     */
    private $writeResults = [];

    public function __construct(\MongoDB\Driver\Manager $manager, string $databaseName)
    {
        $this->_manager = $manager;
        $this->_alias = $databaseName;
    }

    /**
     * Execute all queries
     * @param string|null $collectionName
     * @param null $query
     * @return \MongoDB\Driver\Cursor|WriteResult[]
     */
    public function execute(string $collectionName = null, $query = null)
    {
        if ($query !== null) {
            $cursor = $this->_manager->executeQuery($this->_alias.'.'.$collectionName, $query);
            $cursor->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
            return $cursor;
        }

        foreach ($this->_bulks as $collectionName => $write) {
            $this->writeResults[$collectionName] = $this->_manager->executeBulkWrite($this->_alias.'.'.$collectionName, $write);
            unset($this->_bulks[$collectionName]);
        }
        return $this->writeResults;
    }

    /**
     * @param string $collection
     * @param array $data
     * @return InsertQuery
     */
    public function insert(string $collection, array $data)
    {
        return new InsertQuery(
            $data,
            $this->getWrites($collection)
        );
    }

    /**
     * @return \MongoDB\Driver\Manager
     */
    public function getMongoManager()
    {
        return $this->_manager;
    }

    /**
     * @param string $collection
     * @param array $data
     * @return UpdateQuery
     */
    public function update(string $collection, array $data)
    {
        return new UpdateQuery(
            $data,
            $this->getWrites($collection)
        );
    }

    /**
     * @param string $collection
     * @return DeleteQuery
     */
    public function delete(string $collection)
    {
        return new DeleteQuery(
            $this->getWrites($collection)
        );
    }

    /**
     * @param string $collection
     * @return FindQuery
     */
    public function find(string $collection)
    {
        return new FindQuery(
            $collection,
            $this
        );
    }

    /**
     * @param string $collectionName
     * @return BulkWrite
     */
    private function getWrites(string $collectionName)
    {
        return $this->_bulks[$collectionName] ?? $this->_bulks[$collectionName] = new BulkWrite();
    }
}