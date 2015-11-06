<?php

namespace BinSoul\Db;

use BinSoul\Db\Definition\Column;
use BinSoul\Db\Definition\ForeignKey;
use BinSoul\Db\Definition\Index;
use BinSoul\Db\Definition\PrimaryKey;
use BinSoul\Db\Definition\Schema;
use BinSoul\Db\Definition\Table;

/**
 * Provides methods to get information about a database.
 */
interface DefinitionProvider
{
    /**
     * Returns a list of schemas of the database.
     *
     * @return Schema[]
     */
    public function listSchemas();

    /**
     * Returns a list of tables of the given schema.
     *
     * @param Schema $schema
     *
     * @return Table[]
     */
    public function listTables(Schema $schema = null);

    /**
     * Returns a list of columns of the given table.
     *
     * @param Table  $table
     * @param Schema $schema
     *
     * @return Column[]
     */
    public function listColumns(Table $table, Schema $schema = null);

    /**
     * Returns the primary key of the given table.
     *
     * @param Table  $table
     * @param Schema $schema
     *
     * @return PrimaryKey|null
     */
    public function getPrimaryKey(Table $table, Schema $schema = null);

    /**
     * Returns a list of foreign keys of the given table.
     *
     * @param Table  $table
     * @param Schema $schema
     *
     * @return ForeignKey[]
     */
    public function listForeignKeys(Table $table, Schema $schema = null);

    /**
     * Returns a list of indexes of the given table.
     *
     * @param Table  $table
     * @param Schema $schema
     *
     * @return Index[]
     */
    public function listIndexes(Table $table, Schema $schema = null);
}
