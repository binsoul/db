<?php

namespace BinSoul\Db;

/**
 * Provides methods to execute statements using a pool of connections to databases of a single platform.
 */
interface Database
{
    /**
     * Returns rows from the given table.
     *
     * @param string   $table      name of the table
     * @param string[] $columns    list of columns
     * @param string   $condition  sql where condition
     * @param mixed[]  $parameters list of bound parameters
     *
     * @return Result
     */
    public function select($table, array $columns, $condition = '', array $parameters = []);

    /**
     * Inserts a new row into the given table.
     *
     * @param string  $table name of the table
     * @param mixed[] $data  data to insert indexed by column name
     *
     * @return Result
     */
    public function insert($table, array $data);

    /**
     * Updates rows of the given table.
     *
     * @param string  $table     name of the table
     * @param mixed[] $data      data to update indexed by column name
     * @param string  $condition sql where condition
     *
     * @return Result
     */
    public function update($table, array $data, $condition = '');

    /**
     * Deletes rows from the given table.
     *
     * @param string $table     name of the table
     * @param string $condition sql where condition
     *
     * @return Result
     */
    public function delete($table, $condition = '');

    /**
     * Executes an arbitrary statement.
     *
     * @param string  $statement               sql statement to execute
     * @param mixed[] $parameters              list of bound parameters
     * @param bool    $requiresWriteConnection indicates if a write connection should be used
     *
     * @return Result
     */
    public function execute($statement, array $parameters = [], $requiresWriteConnection = false);

    /**
     * Starts a new transaction.
     *
     * @return bool
     */
    public function begin();

    /**
     * Commits the current transaction.
     *
     * @return bool
     */
    public function commit();

    /**
     * Rolls back the current transaction.
     *
     * @return bool
     */
    public function rollback();

    /**
     * Returns the platform.
     *
     * @return Platform
     */
    public function getPlatform();
}
