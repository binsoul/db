<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the SMALLINT SQL data type.
 */
class SmallIntegerType extends IntegerType
{
    public function getSQLName()
    {
        return 'SMALLINT';
    }
}
