<?php

namespace BinSoul\Db\Definition;

/**
 * Represents a database schema.
 */
class Schema
{
    /** @var string */
    private $name;
    /** @var Table[] */
    private $tables;

    /**
     * Constructs an instance of this class.
     *
     * @param string  $name
     * @param Table[] $tables
     */
    public function __construct($name, array $tables)
    {
        $this->name = $name;
        $this->tables = $tables;
    }

    /**
     * Returns the name of the schema.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns all tables of the schema.
     *
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * Returns the table with the given name.
     *
     * @param string $name
     *
     * @return Table|null
     */
    public function getTable($name)
    {
        foreach ($this->tables as $table) {
            if ($table->getName() == $name) {
                return $table;
            }
        }

        return;
    }

    /**
     * Adds a table to the schema definition.
     *
     * @param Table $table
     */
    public function addTable(Table $table)
    {
        $this->tables[] = $table;
    }
}
