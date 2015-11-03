<?php

namespace BinSoul\Db\Definition\DataType;

use BinSoul\Db\Definition\DataType;

/**
 * Represents the DECIMAL SQL data type.
 */
class DecimalType extends AbstractType
{
    /** @var int */
    private $precision;
    /** @var int */
    private $scale;

    /**
     * Constructs an instance of this class.
     *
     * @param int $precision total number of digits
     * @param int $scale     number of digits after the decimal point
     */
    public function __construct($precision, $scale)
    {
        $this->precision = $precision;
        $this->scale = $scale;
    }

    /**
     * @return string
     */
    public function getSQLName()
    {
        return 'DECIMAL';
    }

    /**
     * @return string
     */
    public function getPHPName()
    {
        return 'float';
    }
}
