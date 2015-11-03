<?php

namespace BinSoul\Db\Definition;

/**
 * Represents the data type of a column.
 */
interface DataType
{
    /**
     * Returns common SQL name of the type.
     *
     * @return string
     */
    public function getSQLName();

    /**
     * Returns PHP name of the type.
     *
     * @return string
     */
    public function getPHPName();

    /**
     * Returns the length of the type.
     *
     * @return int|null
     */
    public function getLength();

    /**
     * Indicates if the length is fixed or not.
     *
     * @return bool
     */
    public function hasVariableLength();

    /**
     * Returns the total number of digits.
     *
     * @return int|null
     */
    public function getPrecision();

    /**
     * Returns the number of digits after the decimal point.
     *
     * @return int|null
     */
    public function getScale();

    /**
     * Returns the initial data of the type.
     *
     * @return mixed
     */
    public function getInitialValue();
}
