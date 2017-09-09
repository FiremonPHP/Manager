<?php
namespace FiremonPHP\Manager\Queries;


use FiremonPHP\Manager\Expression\ConditionsExpression;

class UpdateQuery
{
    private $_conditions;
    private $_options = [];
    private $_data;

    /**
     * @var \MongoDB\Driver\BulkWrite
     */
    private $bulk;

    public function __construct(array $data, $bulk)
    {
        $this->_data = $data;
        $this->bulk = &$bulk;
        $this->_conditions = new ConditionsExpression();
    }

    /**
     * @return ConditionsExpression
     */
    public function conditions()
    {
        return $this->_conditions;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setMulti(bool $value = true)
    {
        $this->_options['multi'] = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setUpsert(bool $value = true)
    {
        $this->_options['upsert'] = $value;
        return $this;
    }

    /**
     * Persist all data, conditions and options on bulk
     */
    public function persist()
    {
        $this->bulk->update((array)$this->_conditions, ['$set' => $this->_data], $this->_options);
    }
}