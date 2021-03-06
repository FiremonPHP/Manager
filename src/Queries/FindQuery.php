<?php
namespace FiremonPHP\Manager\Queries;

use FiremonPHP\Manager\Expression\ConditionsExpression;
use FiremonPHP\Manager\Manager;
use MongoDB\Driver\Query;

class FindQuery extends ConditionsExpression
{
    /**
     * @var Manager
     */
    private $_manger;

    /**
     * @var array
     */
    private $_options = [];
    /**
     * @var string
     */
    private $collectionName;

    public function __construct(string $collectionName, Manager $manager)
    {
        $this->_manger = $manager;
        $this->collectionName = $collectionName;
    }

    /**
     * Set fields of document
     * @param array $fieldsName
     * @return $this
     */
    public function fields(array $fieldsName)
    {
        array_map(function($value){
            $this->_options['projection'][$value] = '1';
        }, $fieldsName);
        return $this;
    }

    /**
     * @param string $fieldName
     * @return $this
     */
    public function ascBy(string $fieldName)
    {
        $this->_options['sort'][$fieldName] = '1';
        return $this;
    }

    /**
     * @param string $fieldName
     * @return $this
     */
    public function descBy(string $fieldName)
    {
        $this->_options['sort'][$fieldName] = '-1';
        return $this;
    }

    /**
     * @param int $limitNumber
     * @return $this
     */
    public function limit(int $limitNumber)
    {
        $this->_options['limit'] = $limitNumber;
        return $this;
    }

    /**
     * @param int $skipNumber
     * @return $this
     */
    public function skip(int $skipNumber)
    {
        $this->_options['skip'] = $skipNumber;
        return $this;
    }

    /**
     * @return \MongoDB\Driver\Cursor
     */
    public function execute()
    {
        $query = new Query($this->_conditions, $this->_options);
        return $this->_manger->execute(
            $this->collectionName,
            $query
        );
    }
}