<?php

namespace BinSoul\Test\Db;

use BinSoul\Db\Connection;
use BinSoul\Db\ConnectionPool;
use BinSoul\Db\DefaultDatabase;
use BinSoul\Db\Exception\ConnectionException;
use BinSoul\Db\Exception\OperationException;
use BinSoul\Db\Platform;
use BinSoul\Db\StatementBuilder;

class DefaultDatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Platform
     */
    private function buildPlatform()
    {
        $connection = $this->getMock(Connection::class);
        $connection->method('execute')->willReturn(null);

        $builder = $this->getMock(StatementBuilder::class);
        $builder->method('selectStatement')->willReturn('select');
        $builder->method('insertStatement')->willReturn('insert');
        $builder->method('insertParameters')->willReturnArgument(0);
        $builder->method('updateStatement')->willReturn('update');
        $builder->method('updateParameters')->willReturnArgument(0);
        $builder->method('deleteStatement')->willReturn('delete');

        $result = $this->getMock(Platform::class);
        $result->expects($this->any())->method('buildConnection')->willReturn($connection);
        $result->expects($this->atLeastOnce())->method('getStatementBuilder')->willReturn($builder);

        return $result;
    }

    /**
     * @param bool $canStartTransaction
     *
     * @return ConnectionPool
     */
    private function buildConnectionPool($canStartTransaction = true)
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->method('execute')->willReturn(null);

        $connection2 = $this->getMock(Connection::class);
        $connection2->method('execute')->willReturn(null);
        $connection2->method('begin')->willReturn($canStartTransaction);

        $result = $this->getMock(ConnectionPool::class);
        $result->method('selectReadConnection')->willReturn($connection1);
        $result->method('selectWriteConnection')->willReturn($connection2);

        return $result;
    }

    public function test_uses_platform()
    {
        $platform = $this->buildPlatform();
        $db = new DefaultDatabase($platform, $this->buildConnectionPool());

        $this->assertSame($platform, $db->getPlatform());
    }

    public function test_rolls_back_transaction_on_destruct()
    {
        $connection = $this->getMock(Connection::class);
        $connection->method('execute')->willReturn(null);
        $connection->method('begin')->willReturn(true);
        $connection->expects($this->once())->method('rollback')->willReturn(true);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $db->begin();

        $db = null;
    }

    public function test_select()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('execute')->withConsecutive(['select'])->willReturn('result');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectReadConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('result', $db->select('table', ['*']));
    }

    public function test_insert()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('execute')->withConsecutive(['insert'])->willReturn('result');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('result', $db->insert('table', []));
    }

    public function test_update()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('execute')->withConsecutive(['update'])->willReturn('result');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('result', $db->update('table', []));
    }

    public function test_delete()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('execute')->withConsecutive(['delete'])->willReturn('result');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('result', $db->delete('table', ''));
    }

    public function test_execute()
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->once())->method('execute')->withConsecutive(['write'])->willReturn('result');

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->once())->method('execute')->withConsecutive(['read'])->willReturn('result');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection1);
        $pool->method('selectReadConnection')->willReturn($connection2);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('result', $db->execute('write', [], true));
        $this->assertEquals('result', $db->execute('read', [], false));
    }

    public function test_begin_uses_transaction_connection()
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->once())->method('begin')->willReturn(true);
        $connection1->expects($this->any())->method('execute')->willReturn('write');

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->any())->method('execute')->willReturn('read');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection1);
        $pool->method('selectReadConnection')->willReturn($connection2);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('read', $db->select('table', ['*']));

        $this->assertTrue($db->begin());

        $this->assertEquals('write', $db->select('table', ['*']));
        $this->assertEquals('write', $db->update('table', ['*']));
    }

    public function test_begin_returns_false()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('begin')->willReturn(false);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertFalse($db->begin());
    }

    public function test_commit()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('begin')->willReturn(true);
        $connection->expects($this->once())->method('commit')->willReturn(true);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertFalse($db->commit());

        $this->assertTrue($db->begin());
        $this->assertTrue($db->commit());
    }

    public function test_rollback()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('begin')->willReturn(true);
        $connection->expects($this->once())->method('rollback')->willReturn(true);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertFalse($db->rollback());

        $this->assertTrue($db->begin());
        $this->assertTrue($db->rollback());
    }

    public function test_disables_read_connection_on_error()
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->any())->method('execute')->willThrowException(new ConnectionException('ex'));

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->any())->method('execute')->willReturn('read');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->expects($this->once())->method('disableReadConnection');
        $pool->method('selectReadConnection')->willReturnOnConsecutiveCalls($connection1, $connection2);
        $pool->method('getReadConnectionCount')->willReturnOnConsecutiveCalls(2, 1);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('read', $db->select('table', ['*']));
    }

    /**
     * @expectedException \BinSoul\Db\Exception\ConnectionException
     */
    public function test_throws_exception_if_no_more_read_connections_available()
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->any())->method('execute')->willThrowException(new ConnectionException('ex'));

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectReadConnection')->willReturn($connection1);
        $pool->method('getReadConnectionCount')->willReturnOnConsecutiveCalls(0);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $db->select('table', []);
    }

    public function test_disables_write_connection_on_error()
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->any())->method('execute')->willThrowException(new ConnectionException('ex'));

        $connection2 = $this->getMock(Connection::class);
        $connection2->expects($this->any())->method('execute')->willReturn('write');

        $pool = $this->getMock(ConnectionPool::class);
        $pool->expects($this->once())->method('disableWriteConnection');
        $pool->method('selectWriteConnection')->willReturnOnConsecutiveCalls($connection1, $connection2);
        $pool->method('getWriteConnectionCount')->willReturnOnConsecutiveCalls(2, 1);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $this->assertEquals('write', $db->update('table', []));
    }

    /**
     * @expectedException \BinSoul\Db\Exception\ConnectionException
     */
    public function test_throws_exception_if_no_more_write_connections_available()
    {
        $connection1 = $this->getMock(Connection::class);
        $connection1->expects($this->any())->method('execute')->willThrowException(new ConnectionException('ex'));

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectWriteConnection')->willReturn($connection1);
        $pool->method('getWriteConnectionCount')->willReturnOnConsecutiveCalls(0);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);
        $db->update('table', []);
    }

    public function test_expands_placeholders()
    {
        $connection = $this->getMock(Connection::class);
        $connection->expects($this->once())->method('execute')->willReturnArgument(0);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectReadConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);

        $statement = 'SELECT * FROM table WHERE col1 = ? AND col2 IN (...?) AND col3 IN(...?) AND c4=?';
        $expected = 'SELECT * FROM table WHERE col1 = ? AND col2 IN (?) AND col3 IN(?,?) AND c4=?';
        $this->assertEquals($expected, $db->execute($statement, [1, [2], [3, 4], [5]], false));
    }

    /**
     * @expectedException \BinSoul\Db\Exception\OperationException
     */
    public function test_throws_exception_for_invalid_placeholders()
    {
        $connection = $this->getMock(Connection::class);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectReadConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);

        $statement = 'SELECT * FROM table WHERE col1 IN (...?)';
        $db->execute($statement, [1], false);
    }

    public function test_uses_statement_in_exception()
    {
        $connection = $this->getMock(Connection::class);

        $pool = $this->getMock(ConnectionPool::class);
        $pool->method('selectReadConnection')->willReturn($connection);

        /* @var ConnectionPool $pool */
        $db = new DefaultDatabase($this->buildPlatform(), $pool);

        try {
            $db->execute('...?', [1], false);
        } catch (OperationException $e) {
            $this->assertEquals('...?', $e->getStatement());
        }
    }
}
