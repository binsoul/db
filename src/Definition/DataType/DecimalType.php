<?php

namespace BinSoul\Db\Definition\DataType;

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

    public function getSQLName()
    {
        return 'DECIMAL';
    }

    public function getPHPName()
    {
        return 'float';
    }

    public function getInitialValue()
    {
        return 0.0;
    }
}
