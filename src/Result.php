<?php

namespace BinSoul\Db;

/**
 * Provides access to the result of an executed statement.
 */
interface Result
{
    /**
     * Returns all rows.
     *
     * @return mixed[][]
     */
    public function all();

    /**
     * Returns the first row.
     *
     * @return mixed[]
     */
    public function row();

    /**
     * Returns a single column of all rows.
     *
     * @param string $name name of the column
     *
     * @return mixed[]
     */
    public function column($name);

    /**
     * Returns a single column from the first row.
     *
     * @param string $name name of the column
     *
     * @return mixed
     */
    public function cell($name);

    /**
     * @return int|string
     */
    public function autoIncrementID();

    /**
     * @return int
     */
    public function affectedRows();
}
