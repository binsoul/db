<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the TIMESTAMP SQL data type.
 */
class UnixTimestampType extends IntegerType
{
    public function getSQLName()
    {
        return 'TIMESTAMP';
    }
}
