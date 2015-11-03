<?php

namespace BinSoul\Db\Definition;

/**
 * Represents a column of a database table.
 */
class Column
{
    /** @var string */
    private $name;
    /** @var DataType */
    private $dataType;
    /** @var bool */
    private $isNullable;
    /** @var bool */
    private $isAutoincrement = false;
    /** @var bool */
    private $hasDefaultValue = false;
    /** @var mixed */
    private $defaultValue = null;
    /** @var string */
    private $comment = '';

    /**
     * Constructs an instance of this class.
     *
     * @param string   $name
     * @param DataType $dataType
     * @param bool     $isNullable
     */
    public function __construct($name, DataType $dataType, $isNullable)
    {
        $this->name = $name;
        $this->dataType = $dataType;
        $this->isNullable = $isNullable;
    }

    /**
     * Returns the name of the column.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the data type of the column.
     *
     * @return DataType
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Indicates if the values in the column can be null.
     *
     * @return bool
     */
    public function isNullable()
    {
        return $this->isNullable;
    }

    /**
     * Indicates if the values in the column are automatically incremented.
     *
     * @return bool
     */
    public function isAutoincrement()
    {
        return $this->isAutoincrement;
    }

    /**
     * Marks the column values as automatically incremented.
     */
    public function setAutoincrement()
    {
        $this->isAutoincrement = true;
    }

    /**
     * Indicates if a default value exists.
     *
     * @return bool
     */
    public function hasDefaultValue()
    {
        return $this->hasDefaultValue;
    }

    /**
     * Returns the default value of the column.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Sets the default value of the column.
     *
     * @param mixed $value
     */
    public function setDefaultValue($value)
    {
        $this->hasDefaultValue = true;
        $this->defaultValue = $value;
    }

    /**
     * Returns the comment for the column.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
