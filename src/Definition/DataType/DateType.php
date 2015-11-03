<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the DATE SQL data type.
 */
class DateType extends AbstractType
{
    public function getSQLName()
    {
        return 'DATE';
    }

    public function getPHPName()
    {
        return 'string';
    }

    public function getInitialValue()
    {
        return '0000-00-00';
    }
}
