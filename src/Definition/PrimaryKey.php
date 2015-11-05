<?php

namespace BinSoul\Db\Definition;

/**
 * Represents the primary key of a database table.
 */
class PrimaryKey
{
    /** @var Column[] */
    private $columns;

    /**
     * Constructs an instance of this class.
     *
     * @param Column[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * Returns the columns of the primary key.
     *
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }
}
