<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the BOOLEAN SQL data type.
 */
class BooleanType extends AbstractType
{
    public function getSQLName()
    {
        return 'BOOLEAN';
    }

    public function getPHPName()
    {
        return 'bool';
    }

    public function getInitialValue()
    {
        return false;
    }
}
