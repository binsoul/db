<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the BIGINT SQL data type.
 */
class BigIntegerType extends IntegerType
{
    public function getSQLName()
    {
        return 'BIGINT';
    }
}
