<?php

namespace BinSoul\Db;

/**
 * Represents a connection to a database.
 */
interface Connection
{
    /**
     * Opens the connection.
     *
     * @return bool
     */
    public function open();

    /**
     * Closes the connection.
     *
     * @return bool
     */
    public function close();

    /**
     * Executes an arbitrary statement.
     *
     * @param string  $statement
     * @param mixed[] $parameters
     *
     * @return Result
     */
    public function execute($statement, array $parameters = []);

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
}
