<?php

namespace BinSoul\Db;

use BinSoul\Db\Exception\ConnectionException;
use BinSoul\Db\Exception\DatabaseException;

/**
 * Provides a default implementation if the {@see ConnectionPool} interface.
 *
 * This pool selects a random entry from the provided lists of available read and write connections.
 * It opens a new connection to a different endpoint if the current connection is marked as failed.
 */
class DefaultConnectionPool implements ConnectionPool
{
    /** @var Connection[] */
    private $readConnections = [];
    /** @var Connection[] */
    private $writeConnections = [];

    /** @var Connection */
    private $currentReadConnection;
    /** @var Connection */
    private $currentWriteConnection;

    public function addReadConnection(Connection $connection)
    {
        $this->readConnections[] = $connection;
    }

    public function addWriteConnection(Connection $connection)
    {
        $this->writeConnections[] = $connection;
    }

    public function disableReadConnection(Connection $connection)
    {
        if ($this->currentReadConnection === $connection) {
            if ($this->currentWriteConnection === $connection) {
                $this->currentWriteConnection = null;
            }

            $this->currentReadConnection->close();
            $this->currentReadConnection = null;
        }

        foreach ($this->readConnections as $index => $readConnection) {
            if ($readConnection === $connection) {
                unset($this->readConnections[$index]);
            }
        }

        $this->readConnections = array_values($this->readConnections);
    }

    public function disableWriteConnection(Connection $connection)
    {
        if ($this->currentWriteConnection === $connection) {
            if ($this->currentReadConnection === $connection) {
                $this->currentReadConnection = null;
            }

            $this->currentWriteConnection->close();
            $this->currentWriteConnection = null;
        }

        foreach ($this->writeConnections as $index => $writeConnection) {
            if ($writeConnection === $connection) {
                unset($this->writeConnections[$index]);
            }
        }

        $this->writeConnections = array_values($this->writeConnections);
    }

    public function selectReadConnection()
    {
        if ($this->currentReadConnection !== null) {
            return $this->currentReadConnection;
        }

        if (count($this->readConnections) == 0) {
            $this->currentReadConnection = $this->selectWriteConnection();

            return $this->currentReadConnection;
        }

        shuffle($this->readConnections);
        $this->currentReadConnection = $this->connect($this->readConnections);

        return $this->currentReadConnection;
    }

    public function selectWriteConnection()
    {
        if ($this->currentWriteConnection !== null) {
            return $this->currentWriteConnection;
        }

        if (count($this->writeConnections) == 0) {
            throw new ConnectionException('No connection available.');
        }

        shuffle($this->writeConnections);
        $this->currentWriteConnection = $this->connect($this->writeConnections);

        return $this->currentWriteConnection;
    }

    public function getReadConnectionCount()
    {
        $result = count($this->readConnections);
        if ($this->currentReadConnection !== null) {
            ++$result;
        }

        if ($this->currentWriteConnection !== null && $this->currentWriteConnection !== $this->currentReadConnection) {
            ++$result;
        }

        return $result + count($this->writeConnections);
    }

    public function getWriteConnectionCount()
    {
        $result = count($this->writeConnections);
        if ($this->currentWriteConnection !== null) {
            ++$result;
        }

        return $result;
    }

    /**
     * Calls the connect method for every connection in the given array and returns the connection on success.
     *
     * @param Connection[] $connections
     *
     * @throws ConnectionException
     *
     * @return Connection
     */
    private function connect(array &$connections)
    {
        $exceptions = [];
        while (count($connections) > 0) {
            /** @var Connection $connection */
            $connection = array_pop($connections);

            try {
                if ($connection->open()) {
                    return $connection;
                }
            } catch (DatabaseException $e) {
                $exceptions[] = $e->getMessage();
            }
        }

        throw new ConnectionException(
            'Unable to select connection.',
            '',
            0,
            count($exceptions) > 0 ? new ConnectionException(implode(' ', $exceptions)) : null
        );
    }
}
