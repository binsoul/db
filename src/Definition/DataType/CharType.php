<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

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

    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'CHAR';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'string';
    }

    /**
     * @return int|null
     */
    public function getLength()
    {
        return $this->length;
    }
}
