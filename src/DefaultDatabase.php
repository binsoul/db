<?php

namespace BinSoul\Db;

use BinSoul\Db\Exception\ConnectionException;
use BinSoul\Db\Exception\OperationException;

/**
 * Provides a default implementation if the {@see Database} interface.
 */
class DefaultDatabase implements Database
{
    /** @var ConnectionPool */
    private $pool;
    /** @var Platform */
    private $platform;
    /** @var StatementBuilder */
    private $statementBuilder;
    /** @var int */
    private $transactionCount;
    /** @var Connection */
    private $transactionConnection;

    /**
     * Constructs an instance of this class.
     *
     * @param Platform       $platform
     * @param ConnectionPool $pool
     */
    public function __construct(Platform $platform, ConnectionPool $pool)
    {
        $this->pool = $pool;
        $this->platform = $platform;
        $this->statementBuilder = $this->platform->getStatementBuilder();
    }

    /**
     * Destructs an instance of this class.
     */
    public function __destruct()
    {
        while ($this->transactionCount > 0) {
            $this->rollback();
        }
    }

    public function select($table, array $columns, $condition = '', array $parameters = [])
    {
        return $this->executeRead(
            $this->statementBuilder->selectStatement($table, $columns, $condition),
            $parameters
        );
    }

    public function insert($table, array $data)
    {
        return $this->executeWrite(
            $this->statementBuilder->insertStatement($table, $data),
            $this->statementBuilder->insertParameters($data)
        );
    }

    public function update($table, array $data, $condition = '', array $parameters = [])
    {
        return $this->executeWrite(
            $this->statementBuilder->updateStatement($table, $data),
            array_merge($this->statementBuilder->updateParameters($data), $parameters)
        );
    }

    public function delete($table, $condition = '', array $parameters = [])
    {
        return $this->executeWrite(
            $this->statementBuilder->deleteStatement($table, $condition),
            $parameters
        );
    }

    public function execute($statement, array $parameters = [], $requiresWriteConnection = false)
    {
        if ($requiresWriteConnection) {
            return $this->executeWrite($statement, $parameters);
        }

        return $this->executeRead($statement, $parameters);
    }

    public function begin()
    {
        if ($this->transactionCount == 0) {
            $this->transactionConnection = $this->pool->selectWriteConnection();
        }

        if (!$this->transactionConnection->begin()) {
            if ($this->transactionCount == 0) {
                $this->transactionConnection = null;
            }

            return false;
        }

        ++$this->transactionCount;

        return true;
    }

    public function commit()
    {
        if ($this->transactionCount == 0) {
            return false;
        }

        $result = $this->transactionConnection->commit();

        $this->popTransaction();

        return $result;
    }

    public function rollback()
    {
        if ($this->transactionCount == 0) {
            return false;
        }

        $result = $this->transactionConnection->rollback();

        $this->popTransaction();

        return $result;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Executes a statement using a read connection from the pool.
     *
     * @param string  $statement
     * @param mixed[] $parameters
     *
     * @throws ConnectionException
     *
     * @return Result
     */
    private function executeRead($statement, array $parameters)
    {
        if ($this->transactionCount == 0) {
            $connection = $this->pool->selectReadConnection();
        } else {
            $connection = $this->transactionConnection;
        }

        try {
            return $connection->execute(
                $this->expandPlaceholders($statement, $parameters),
                $parameters
            );
        } catch (ConnectionException $e) {
            $this->pool->disableReadConnection($connection);
            if ($this->pool->getReadConnectionCount() == 0) {
                throw $e;
            }

            return $this->executeRead($statement, $parameters);
        }
    }

    /**
     * Executes a statement using a write connection from the pool.
     *
     * @param string  $statement
     * @param mixed[] $parameters
     *
     * @throws ConnectionException
     *
     * @return Result
     */
    private function executeWrite($statement, array $parameters)
    {
        if ($this->transactionCount == 0) {
            $connection = $this->pool->selectWriteConnection();
        } else {
            $connection = $this->transactionConnection;
        }

        try {
            return $connection->execute(
                $this->expandPlaceholders($statement, $parameters),
                $parameters
            );
        } catch (ConnectionException $e) {
            $this->pool->disableWriteConnection($connection);
            if ($this->pool->getWriteConnectionCount() == 0) {
                throw $e;
            }

            return $this->executeWrite($statement, $parameters);
        }
    }

    /**
     * Removes the current transaction from the stack.
     */
    private function popTransaction()
    {
        --$this->transactionCount;

        if ($this->transactionCount == 0) {
            $this->transactionConnection = null;
        }
    }

    /**
     * Replaces variable length placeholders with the real number of placeholder.
     *
     * @param string  $statement
     * @param mixed[] $parameters
     *
     * @throws OperationException
     *
     * @return string
     */
    private function expandPlaceholders($statement, array $parameters)
    {
        $index = 0;

        return preg_replace_callback(
            '/[\.]{3}\?|\?/',
            function ($match) use (&$index, &$statement, &$parameters) {
                if ($match[0] != '...?') {
                    ++$index;

                    return $match[0];
                }

                if (!is_array($parameters[$index]) || count($parameters[$index]) == 0) {
                    throw new OperationException(
                        sprintf(
                            'Variable length parameter %d is not an array.',
                            $index
                        ),
                        $statement
                    );
                }

                $result = implode(',', array_fill(0, count($parameters[$index]), '?'));

                ++$index;

                return $result;
            },
            $statement
        );
    }
}
