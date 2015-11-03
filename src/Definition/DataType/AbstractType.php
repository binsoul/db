<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Provides default implementations of the {@see DataType} interface methods.
 */
abstract class AbstractType implements DataType
{
    abstract public function getSQLName();

    abstract public function getPHPName();

    public function getLength()
    {
        return;
    }

    public function hasVariableLength()
    {
        return false;
    }

    public function getPrecision()
    {
        return;
    }

    public function getScale()
    {
        return;
    }

    abstract public function getInitialValue();
}
