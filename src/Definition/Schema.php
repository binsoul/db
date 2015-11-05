<?php

namespace BinSoul\Db\Definition;

/**
 * Represents a database schema.
 */
class Schema
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
     * Returns the name of the schema.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
