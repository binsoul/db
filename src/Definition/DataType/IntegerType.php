<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the INT SQL data type.
 */
class IntegerType extends AbstractType
{
    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'INT';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'int';
    }
}
