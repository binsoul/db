<?php

namespace BinSoul\Db\Definition;

/**
 * Represents a table of a database schema.
 */
class Table
{
    /** @var string */
    private $name;
    /** @var Column[] */
    private $columns;

    /**
     * Constructs an instance of this class.
     *
     * @param string   $name
     * @param Column[] $columns
     */
    public function __construct($name, array $columns)
    {
        $this->name = $name;
        $this->columns = $columns;
    }

    /**
     * Returns the name of the table.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns all columns of the table.
     *
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Returns the column with the given name.
     *
     * @param string $name
     *
     * @return Column|null
     */
    public function getColumn($name)
    {
        foreach ($this->columns as $column) {
            if ($column->getName() == $name) {
                return $column;
            }
        }

        return;
    }
}
