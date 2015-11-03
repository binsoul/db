<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the INT SQL data type.
 */
class IntegerType extends AbstractType
{
    public function getSQLName()
    {
        return 'INT';
    }

    public function getPHPName()
    {
        return 'int';
    }

    public function getInitialValue()
    {
        return 0;
    }
}
