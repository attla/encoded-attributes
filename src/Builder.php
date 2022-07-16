<?php

namespace Attla\EncodedAttributes;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder extends EloquentBuilder
{
    /**
     * Find a model by its primary key
     *
     * @param mixed $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*'])
    {
        return parent::find(Factory::resolve($id), $columns);
    }

    /**
     * Add a basic where clause to the query
     *
     * @param \Closure|string|array|\Illuminate\Database\Query\Expression $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return parent::where(...Factory::resolve(func_get_args()));
    }

    /**
     * Update records in the database
     *
     * @param array $values
     * @return int
     */
    public function update(array $values)
    {
        return parent::update(Factory::resolve($values));
    }

    /**
     * Insert new records or update the existing ones
     *
     * @param array $values
     * @param array|string $uniqueBy
     * @param array|null $update
     * @return int
     */
    public function upsert(array $values, $uniqueBy, $update = null)
    {
        return parent::upsert(
            Factory::resolve($values),
            $uniqueBy,
            Factory::resolve($update),
        );
    }

    /**
     * Insert new records into the database
     *
     * @param array $values
     * @return bool
     */
    public function insert(array $values)
    {
        return parent::forwardCallTo(
            parent::$query,
            'insert',
            [Factory::resolve($values)]
        );
    }
}
