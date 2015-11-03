<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the TIME SQL data type.
 */
class TimeType extends AbstractType
{
    public function getSQLName()
    {
        return 'TIME';
    }

    public function getPHPName()
    {
        return 'string';
    }

    public function getInitialValue()
    {
        return '00:00:00';
    }
}
