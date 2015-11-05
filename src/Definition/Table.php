<?php

namespace BinSoul\Db\Definition;

/**
 * Represents a table of a database schema.
 */
class Table
{
    /** @var string */
    private $name;

    /**
     * Constructs an instance of this class.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
}
