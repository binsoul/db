<?php

namespace BinSoul\Db\Definition;

/**
 * Represents an index of a database table.
 */
class Index
{
    /** @var string */
    private $name;
    /** @var string[] */
    private $columns;
    /** @var string */
    private $type;

    /**
     * Constructs an instance of this class.
     *
     * @param string   $name
     * @param string[] $columns
     * @param string   $type
     */
    public function __construct($name, array $columns, $type = '')
    {
        $this->name = $name;
        $this->columns = $columns;
        $this->type = $type;
    }

    /**
     * Returns the name of the index.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the columns of the index.
     *
     * @return \string[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Returns the type of the index.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
