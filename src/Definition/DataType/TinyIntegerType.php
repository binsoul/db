<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the TINYINT SQL data type.
 */
class TinyIntegerType extends IntegerType
{
    public function getSQLName()
    {
        return 'TINYINT';
    }
}
