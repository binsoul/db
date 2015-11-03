<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the FLOAT SQL data type.
 */
class FloatType extends AbstractType
{
    public function getSQLName()
    {
        return 'FLOAT';
    }

    public function getPHPName()
    {
        return 'float';
    }

    public function getInitialValue()
    {
        return 0;
    }
}
