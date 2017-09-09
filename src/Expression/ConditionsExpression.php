<?php
namespace FiremonPHP\Manager\Expression;


class ConditionsExpression
{
    /**
     * @var array
     */
    protected $_conditions = [];

    public function notEqual(string $field, $value)
    {
        $this->_conditions[$field]['$ne'] = $value;
        return $this;
    }

    public function equalTo(string $field, $value)
    {
        $this->_conditions[$field]['$eq'] = $value;
        return $this;
    }

    public function startAt(string $field, $value)
    {
        $this->_conditions[$field]['$gte'] = $value;
        return $this;
    }

    public function endAt(string $field, $value)
    {
        $this->_conditions[$field]['$lt'] = $value;
        return $this;
    }
}