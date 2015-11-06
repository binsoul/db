<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the DOUBLE SQL data type.
 */
class DoubleType extends AbstractType
{
    public function getSQLName()
    {
        return 'DOUBLE';
    }

    public function getPHPName()
    {
        return 'float';
    }

    public function getInitialValue()
    {
        return 0.0;
    }
}
