<?php

namespace BinSoul\Db\Exception;

/**
 * Represents the base class for all database related exceptions.
 */
abstract class DatabaseException extends \Exception
{
    /** @var string */
    private $statement;

    /**
     * @param string     $message
     * @param string     $statement
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $statement = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->statement = $statement;
    }

    /**
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }
}
