<?php

namespace BinSoul\Db;

/**
 * Represents platform specific connection settings.
 */
interface ConnectionSettings
{
    /**
     * Constructs a new instance from the given array.
     *
     * @param array $settings
     *
     * @return static
     */
    public static function fromArray(array $settings);

    /**
     * Indicates if the endpoint of this connection accepts statements which modify data.
     *
     * @return bool
     */
    public function isWritable();
}
