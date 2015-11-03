<?php

namespace BinSoul\Db\Definition\DataType;

/**
 * Represents the CHAR SQL data type.
 */
class CharType extends AbstractType
{
    /** @var int */
    private $length;

    /**
     * Constructs an instance of this class.
     *
     * @param int $length number of chars of the string
     */
    public function __construct($length)
    {
        $this->length = $length;
    }

    public function getSQLName()
    {
        return 'CHAR';
    }

    public function getPHPName()
    {
        return 'string';
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getInitialValue()
    {
        return str_repeat(' ', $this->length);
    }
}
