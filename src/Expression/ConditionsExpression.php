<?php
namespace FiremonPHP\Manager\Expression;


class ConditionsExpression
{

    public function notEqual(string $field, $value)
    {
        $this->{$field} = ['$ne' => $value];
        return $this;
    }

    public function equalTo(string $field, $value)
    {
        $this->{$field} = ['$eq' => $value];
        return $this;
    }

    public function startAt(string $field, $value)
    {
        $this->{$field} = ['$gte' => $value];
        return $this;
    }

    public function endAt(string $field, $value)
    {
        $this->{$field} = ['$lt' => $value];
        return $this;
    }
}