<?php

namespace BinSoul\Db\Definition;

/**
 * Represents the primary key of a database table.
 */
class PrimaryKey
{
    /** @var string[] */
    private $columns;

    /**
     * Constructs an instance of this class.
     *
     * @param string[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * Returns the columns of the primary key.
     *
     * @return string[]
     */
    public function getColumns()
    {
        return $this->columns;
    }
}
