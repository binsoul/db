<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the TIME SQL data type.
 */
class TimeType extends AbstractType
{
    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'TIME';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'string';
    }
}
