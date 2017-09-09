<?php
namespace FiremonPHP\Manager\Queries;


use FiremonPHP\Manager\Expression\ConditionsExpression;

class DeleteQuery extends ConditionsExpression
{
    private $_options = [
        'limit' => false
    ];

    /**
     * @var \MongoDB\Driver\BulkWrite
     */
    private $_bulk;

    public function __construct(\MongoDB\Driver\BulkWrite $bulk)
    {
        $this->_bulk = $bulk;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function limit(bool $value = false)
    {
        $this->_options['limit'] = $value;
        return $this;
    }

    /**
     * Persist data on bulk
     */
    public function persist()
    {
        $this->_bulk->delete($this->_conditions, $this->_options);
    }
}