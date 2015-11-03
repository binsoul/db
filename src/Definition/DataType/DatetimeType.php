<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the DATETIME SQL data type.
 */
class DatetimeType extends AbstractType
{
    public function getSQLName()
    {
        return 'DATETIME';
    }

    public function getPHPName()
    {
        return 'string';
    }

    public function getInitialValue()
    {
        return '0000-00-00 00:00:00';
    }
}
