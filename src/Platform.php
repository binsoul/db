<?php

namespace BinSoul\Db;

/**
 * Represents a specific database platform.
 */
interface Platform
{
    /**
     * Builds a new connection using the given settings.
     *
     * @param ConnectionSettings $settings
     *
     * @return Connection
     */
    public function buildConnection(ConnectionSettings $settings);

    /**
     * Returns the statement builder for the platform.
     *
     * @return StatementBuilder
     */
    public function getStatementBuilder();

    /**
     * Returns a definition provider for the given connection.
     *
     * @param Connection $connection
     *
     * @return DefinitionProvider
     */
    public function getDefinitionProvider(Connection $connection);
}
