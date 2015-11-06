<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the MEDIUMINT SQL data type.
 */
class MediumIntegerType extends IntegerType
{
    public function getSQLName()
    {
        return 'MEDIUMINT';
    }
}
