<?php
namespace phpcassa\Batch;

use cassandra\ConsistencyLevel;
use phpcassa\ColumnFamily;
use phpcassa\Connection\ConnectionPool;

/**
 * Allows you to group multiple mutations across one or more
 * keys and column families into a single batch operation.
 *
 * @package phpcassa\Batch
 */
class Mutator extends AbstractMutator
{
    /**
     * Initialize a mutator with a connection pool and consistency level.
     *
     * @param ConnectionPool $pool the connection pool to
     *        use for all operations
     * @param int $consistency_level the default consistency
     *        level this mutator will write at, with a default of
     *        ConsistencyLevel::ONE
     */
    public function __construct($pool,
                                $consistency_level = ConsistencyLevel::ONE)
    {
        $this->pool = $pool;
        $this->buffer = array();
        $this->cl = $consistency_level;
    }

    /**
     * Add an insertion to the buffer.
     *
     * @param ColumnFamily $column_family an initialized
     *        ColumnFamily instance
     * @param mixed $key the row key
     * @param mixed[] $columns an array of columns to insert, whose format
     *        should match $column_family->insert_format
     * @param int $timestamp an optional timestamp (default is "now", when
     *        this function is called, not when send() is called)
     * @param int $ttl a TTL to apply to all columns inserted here
     * @return $this
     */
    public function insert($column_family, $key, $columns, $timestamp = null, $ttl = null)
    {
        return $this->insert_cf($column_family, $key, $columns, $timestamp, $ttl);
    }

    /**
     * Add a deletion to the buffer.
     *
     * @param ColumnFamily $column_family an initialized
     *        ColumnFamily instance
     * @param mixed $key the row key
     * @param mixed[] $columns a list of columns or super columns to delete
     * @param string|null $super_column if you want to delete only some subcolumns from
     *        a single super column, set this to the super column name
     * @param int $timestamp an optional timestamp (default is "now", when
     *        this function is called, not when send() is called)
     * @return $this
     */
    public function remove($column_family, $key, $columns = null, $super_column = null, $timestamp = null)
    {
        return $this->remove_cf($column_family, $key, $columns, $super_column, $timestamp);
    }
}
