<?php

namespace BinSoul\Db;

/**
 * Provides methods to build platform specific SQL statements.
 */
interface StatementBuilder
{
    /**
     * Builds a select statement from the given parts.
     *
     * @param string   $table
     * @param string[] $columns
     * @param string   $condition
     *
     * @return string
     */
    public function selectStatement($table, array $columns, $condition = '');

    /**
     * Builds an insert statement from the given parts.
     *
     * @param string  $table
     * @param mixed[] $data
     *
     * @return string
     */
    public function insertStatement($table, array $data);

    /**
     * Filters the data for an insert statement.
     *
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    public function insertParameters(array $data);

    /**
     * Builds an update statement from the given parts.
     *
     * @param string  $table
     * @param mixed[] $data
     * @param string  $condition
     *
     * @return string
     */
    public function updateStatement($table, array $data, $condition = '');

    /**
     * Filters the data for an update statement.
     *
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    public function updateParameters(array $data);

    /**
     * Builds a delete statement from the given parts.
     *
     * @param string $table
     * @param string $condition
     *
     * @return string
     */
    public function deleteStatement($table, $condition = '');
}
