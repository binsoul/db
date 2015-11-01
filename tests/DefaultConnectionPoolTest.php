<?php

namespace BinSoul\Test\Db;

use BinSoul\Db\Connection;
use BinSoul\Db\DefaultConnectionPool;
use BinSoul\Db\Exception\ConnectionException;

class DefaultConnectionPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool|true $canbeOpened
     *
     * @return Connection
     */
    private function buildConnection($canbeOpened = true)
    {
        $result = $this->getMock(Connection::class);
        $result->method('open')->willReturn($canbeOpened);

        return $result;
    }

    public function test_returns_same_write_connection()
    {
        $pool = new DefaultConnectionPool();
        $connection = $this->buildConnection(true);
        $pool->addWriteConnection($connection);

        $this->assertSame($connection, $pool->selectWriteConnection());
        $this->assertSame($connection, $pool->selectWriteConnection());
    }

    public function test_returns_same_read_connection()
    {
        $pool = new DefaultConnectionPool();
        $connection = $this->buildConnection(true);
        $pool->addReadConnection($connection);

        $this->assertSame($connection, $pool->selectReadConnection());
        $this->assertSame($connection, $pool->selectReadConnection());
    }

    public function test_returns_write_connection_if_no_read_connection_available()
    {
        $pool = new DefaultConnectionPool();
        $connection = $this->buildConnection(true);
        $pool->addWriteConnection($connection);

        $this->assertSame($connection, $pool->selectReadConnection());
        $this->assertSame($connection, $pool->selectReadConnection());
    }

    public function test_closes_write_connection()
    {
        $pool = new DefaultConnectionPool();
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->once())->method('open')->willReturn(true);
        $connection1->expects($this->once())->method('close')->willReturn(true);

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->once())->method('open')->willReturn(true);
        $connection2->expects($this->once())->method('close')->willReturn(true);

        /* @var Connection $connection1 */
        $pool->addWriteConnection($connection1);
        /* @var Connection $connection2 */
        $pool->addWriteConnection($connection2);

        $pool->selectReadConnection();

        $connection1 = $pool->selectWriteConnection();
        $pool->disableWriteConnection($connection1);
        $connection2 = $pool->selectWriteConnection();
        $pool->disableWriteConnection($connection2);
    }

    public function test_disables_write_connection()
    {
        $pool = new DefaultConnectionPool();
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->any())->method('open')->willReturn(true);

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->any())->method('open')->willReturn(true);

        /* @var Connection $connection1 */
        $pool->addWriteConnection($connection1);
        /* @var Connection $connection2 */
        $pool->addWriteConnection($connection2);

        $pool->selectReadConnection();

        $connection = $pool->selectWriteConnection();
        if ($connection == $connection1) {
            $pool->disableWriteConnection($connection2);
            $this->assertSame($connection1, $pool->selectWriteConnection());
        } else {
            $pool->disableWriteConnection($connection1);
            $this->assertSame($connection2, $pool->selectWriteConnection());
        }
    }

    public function test_closes_read_connection()
    {
        $pool = new DefaultConnectionPool();
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->once())->method('open')->willReturn(true);
        $connection1->expects($this->once())->method('close')->willReturn(true);

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->once())->method('open')->willReturn(true);
        $connection2->expects($this->once())->method('close')->willReturn(true);

        /* @var Connection $connection1 */
        $pool->addWriteConnection($connection1);
        /* @var Connection $connection2 */
        $pool->addReadConnection($connection2);

        $pool->selectWriteConnection();

        $connection1 = $pool->selectReadConnection();
        $pool->disableReadConnection($connection1);
        $connection2 = $pool->selectReadConnection();
        $pool->disableReadConnection($connection2);
    }

    public function test_disables_read_connection()
    {
        $pool = new DefaultConnectionPool();
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->any())->method('open')->willReturn(true);

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->any())->method('open')->willReturn(true);

        /* @var Connection $connection1 */
        $pool->addReadConnection($connection1);
        /* @var Connection $connection2 */
        $pool->addReadConnection($connection2);

        $connection = $pool->selectReadConnection();
        if ($connection == $connection1) {
            $pool->disableReadConnection($connection2);
            $this->assertSame($connection1, $pool->selectReadConnection());
        } else {
            $pool->disableReadConnection($connection1);
            $this->assertSame($connection2, $pool->selectReadConnection());
        }
    }

    public function test_tries_all_connections_in_pool_if_open_fails()
    {
        $pool = new DefaultConnectionPool();

        $isFirst = true;
        $callback = function () use (&$isFirst) {
            $result = !$isFirst;
            $isFirst = false;

            return $result;
        };

        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->once())->method('open')->willReturnCallback($callback);

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->once())->method('open')->willReturnCallback($callback);

        /* @var Connection $connection1 */
        $pool->addWriteConnection($connection1);
        /* @var Connection $connection2 */
        $pool->addWriteConnection($connection2);

        $pool->selectWriteConnection();
    }

    public function test_tries_all_connections_in_pool_if_open_throws_exception()
    {
        $pool = new DefaultConnectionPool();

        $invocationCount = 0;
        $callback = function () use (&$invocationCount) {
            ++$invocationCount;
            if ($invocationCount == 1) {
                throw new ConnectionException();
            }

            return true;
        };

        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->once())->method('open')->willReturnCallback($callback);

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->once())->method('open')->willReturnCallback($callback);

        /* @var Connection $connection1 */
        $pool->addWriteConnection($connection1);
        /* @var Connection $connection2 */
        $pool->addWriteConnection($connection2);

        $pool->selectWriteConnection();
    }

    /**
     * @expectedException \BinSoul\Db\Exception\ConnectionException
     */
    public function test_throws_exception_none_can_be_opened()
    {
        $pool = new DefaultConnectionPool();

        $pool->addWriteConnection($this->buildConnection(false));
        $pool->addWriteConnection($this->buildConnection(false));

        $pool->selectWriteConnection();
    }

    /**
     * @expectedException \BinSoul\Db\Exception\ConnectionException
     */
    public function test_throws_exception_if_write_pool_is_empty()
    {
        $pool = new DefaultConnectionPool();

        $pool->selectWriteConnection();
    }

    /**
     * @expectedException \BinSoul\Db\Exception\ConnectionException
     */
    public function test_throws_exception_if_read_pool_is_empty()
    {
        $pool = new DefaultConnectionPool();

        $pool->selectReadConnection();
    }

    public function test_counts_write_connections_as_readable()
    {
        $pool = new DefaultConnectionPool();

        $this->assertEquals(0, $pool->getReadConnectionCount());
        $this->assertEquals(0, $pool->getWriteConnectionCount());

        $writeConnection = $this->buildConnection();
        $pool->addWriteConnection($writeConnection);

        $this->assertEquals(1, $pool->getReadConnectionCount());
        $this->assertEquals(1, $pool->getWriteConnectionCount());

        $readConnection = $this->buildConnection();
        $pool->addReadConnection($readConnection);

        $this->assertEquals(2, $pool->getReadConnectionCount());
        $this->assertEquals(1, $pool->getWriteConnectionCount());

        $pool->selectWriteConnection();

        $this->assertEquals(2, $pool->getReadConnectionCount());
        $this->assertEquals(1, $pool->getWriteConnectionCount());

        $pool->selectReadConnection();

        $this->assertEquals(2, $pool->getReadConnectionCount());
        $this->assertEquals(1, $pool->getWriteConnectionCount());

        $pool->disableReadConnection($readConnection);

        $this->assertEquals(1, $pool->getReadConnectionCount());
        $this->assertEquals(1, $pool->getWriteConnectionCount());

        $pool->disableWriteConnection($writeConnection);

        $this->assertEquals(0, $pool->getReadConnectionCount());
        $this->assertEquals(0, $pool->getWriteConnectionCount());
    }
}
