<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the BOOLEAN SQL data type.
 */
class BooleanType extends AbstractType
{
    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'BOOLEAN';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'bool';
    }
}
