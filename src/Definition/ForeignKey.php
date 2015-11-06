<?php

namespace BinSoul\Db\Definition;

/**
 * Represents a foreign key of a database table.
 */
class ForeignKey
{
    /** Whenever rows in the parent table are changed the rows of the child table will be changed as well. */
    const ACTION_CASCADE = 'CASCADE';
    /** A value cannot be changed when a row exists in a child table that references the value in the parent table. */
    const ACTION_RESTRICT = 'RESTRICT';
    /** Same as RESTRICT but the referential integrity check is done after trying to alter the table. */
    const ACTION_NOACTION = 'NO ACTION';
    /** The value of the child table is changed to null. */
    const ACTION_SETNULL = 'SET NULL';
    /** The value of the child table is changed to the specified default value. */
    const ACTION_SETDEFAULT = 'SET DEFAULT';

    /** @var string */
    private $name;
    /** @var string */
    private $childColumn;
    /** @var string */
    private $parentTable;
    /** @var string */
    private $parentColumn;
    /** @var string */
    private $updateAction;
    /** @var string */
    private $deleteAction;

    /**
     * Constructs an instance of this class.
     *
     * @param string $name
     * @param string $childColumn
     * @param string $parentTable
     * @param string $parentColumn
     * @param string $updateAction
     * @param string $deleteAction
     */
    public function __construct(
        $name,
        $childColumn,
        $parentTable,
        $parentColumn,
        $updateAction,
        $deleteAction
    ) {
        $this->name = $name;
        $this->childColumn = $childColumn;
        $this->parentTable = $parentTable;
        $this->parentColumn = $parentColumn;
        $this->updateAction = $updateAction;
        $this->deleteAction = $deleteAction;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the child column.
     *
     * @return string
     */
    public function getChildColumn()
    {
        return $this->childColumn;
    }

    /**
     * Returns the parent table.
     *
     * @return string
     */
    public function getParentTable()
    {
        return $this->parentTable;
    }

    /**
     * Returns the parent column.
     *
     * @return string
     */
    public function getParentColumn()
    {
        return $this->parentColumn;
    }

    /**
     * Returns the update action.
     *
     * @return string
     */
    public function getUpdateAction()
    {
        return $this->updateAction;
    }

    /**
     * Returns the delete action.
     *
     * @return string
     */
    public function getDeleteAction()
    {
        return $this->deleteAction;
    }
}
