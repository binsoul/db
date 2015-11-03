<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the DATETIME SQL data type.
 */
class DatetimeType extends AbstractType
{
    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'DATETIME';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'string';
    }
}
