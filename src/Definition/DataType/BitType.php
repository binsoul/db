<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the CHAR SQL data type.
 */
class BitType extends AbstractType
{
    /** @var int */
    private $length;

    /**
     * Constructs an instance of this class.
     *
     * @param int $length number of bits
     */
    public function __construct($length)
    {
        $this->length = $length;
    }

    public function getSQLName()
    {
        return 'BIT';
    }

    public function getPHPName()
    {
        return 'int';
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getInitialValue()
    {
        return 0;
    }
}
