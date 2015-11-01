<?php

namespace BinSoul\Db;

/**
 * Provides methods to work with a pool of connections.
 *
 * Connections are classified as read connections and write connection. The endpoint of read connection should not
 * accept statements which modify data. The endpoint of a write connection should allow data modification and retrieval.
 */
interface ConnectionPool
{
    /**
     * Adds a read connection to the pool.
     *
     * @param Connection $connection
     */
    public function addReadConnection(Connection $connection);

    /**
     * Adds a write connection to the pool.
     *
     * @param Connection $connection
     */
    public function addWriteConnection(Connection $connection);

    /**
     * Marks a read connection as failed.
     *
     * @param Connection $connection
     */
    public function disableReadConnection(Connection $connection);

    /**
     * Marks a write connection as failed.
     *
     * @param Connection $connection
     */
    public function disableWriteConnection(Connection $connection);

    /**
     * Returns a read connection from the pool.
     *
     * @return Connection
     */
    public function selectReadConnection();

    /**
     * Returns a write connection from the pool.
     *
     * @return Connection
     */
    public function selectWriteConnection();

    /**
     * Returns the number of available read connections.
     *
     * @return int
     */
    public function getReadConnectionCount();

    /**
     * Returns the number of available write connections.
     *
     * @return int
     */
    public function getWriteConnectionCount();
}
