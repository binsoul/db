<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the FLOAT SQL data type.
 */
class FloatType extends AbstractType
{
    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'FLOAT';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'float';
    }
}
