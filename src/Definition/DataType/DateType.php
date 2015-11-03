<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the DATE SQL data type.
 */
class DateType extends AbstractType
{
    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'DATE';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'string';
    }
}
