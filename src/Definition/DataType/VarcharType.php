<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the VARCHAR SQL data type.
 */
class VarcharType extends CharType
{
    public function hasVariableLength()
    {
        return true;
    }

    public function getInitialValue()
    {
        return '';
    }
}
