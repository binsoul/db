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
    /** @var PrimaryKey */
    private $primaryKey;
    /** @var ForeignKey[] */
    private $foreignKeys;
    /** @var Index[] */
    private $indexes;

    /**
     * Constructs an instance of this class.
     *
     * @param string     $name
     * @param Column[]   $columns
     * @param PrimaryKey $primaryKey
     */
    public function __construct($name, array $columns, PrimaryKey $primaryKey)
    {
        $this->name = $name;
        $this->columns = $columns;
        $this->primaryKey = $primaryKey;
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
     * Finds a column with the given name.
     *
     * @param string $name
     *
     * @return Column|null
     */
    public function findColumn($name)
    {
        foreach ($this->columns as $column) {
            if ($column->getName() == $name) {
                return $column;
            }
        }

        return;
    }

    /**
     * Returns the PrimaryKey.
     *
     * @return PrimaryKey
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Sets the primary key.
     *
     * @param PrimaryKey $key
     */
    public function setPrimaryKey(PrimaryKey $key)
    {
        $this->primaryKey = $key;
    }

    /**
     * Returns the foreign keys.
     *
     * @return ForeignKey[]
     */
    public function getForeignKeys()
    {
        return $this->foreignKeys;
    }

    /**
     * Adds a foreign key.
     *
     * @param ForeignKey $key
     */
    public function addForeignKey(ForeignKey $key)
    {
        $this->foreignKeys[] = $key;
    }

    /**
     * Returns the indexes.
     *
     * @return Index[]
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * Adds an index.
     *
     * @param Index $index
     */
    public function addIndex(Index $index)
    {
        $this->indexes[] = $index;
    }
}
