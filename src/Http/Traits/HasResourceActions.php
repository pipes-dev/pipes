<?php

namespace Pipes\Http\Traits;

use Pipes\Stream\Facades\Stream;
use Illuminate\Http\Request;

trait HasResourceActions
{
    /**
     * $_shouldPaginate
     * 
     * @var boolean
     */
    protected $_shouldPaginate = false;

    /**
     * index
     * 
     * List all resources
     * 
     * @author Gustavo Vilas Bôas
     * @since 23/11/2020
     */
    public function index()
    {
        $namespace = $this->_model::getNameSpace();
        return Stream::send("$namespace:index", new $this->_model, function ($model, $next) {
            if ($this->_shouldPaginate) {
                return $next($model->paginate());
            }
            return $next($model->get());
        });
    }

    /**
     * show
     *
     * Show a specific resource
     * 
     * @author Gustavo Vilas Bôas
     * @since 23/11/2020
     */
    public function show($id)
    {
        $namespace = $this->_model::getNameSpace();

        $record = $this->_model::find($id);

        return Stream::send("$namespace:show", $record, function ($args, $next) {
            return $next($args);
        });
    }

    /**
     * update
     *
     * Update a resource
     * 
     * @author Gustavo Vilas Bôas
     * @since 23/11/2020
     */
    public function update($id, Request $request)
    {
        $namespace = $this->_model::getNameSpace();

        return Stream::send("$namespace:update", [$id, $request->all()], function ($args, $next) {

            list($id, $data) = $args;

            $record = $this->model->find($id);

            $record->fill($data)->save();

            return $next($args);
        });
    }

    /**
     * store
     *
     * Creates a new resource
     * 
     * @author Gustavo Vilas Bôas
     * @since 23/11/2020
     */
    public function store(Request $request)
    {
        $namespace = $this->_model::getNameSpace();

        return Stream::send("$namespace:store", $request->all(), function ($args, $next) {
            return $next($this->_model::create($args));
        });
    }

    /**
     * destroy
     *
     * Removes a resource
     * 
     * @author Gustavo Vilas Bôas
     */
    public function destroy($id)
    {
        $namespace = $this->_model::getNameSpace();
        return Stream::send("$namespace:destroy", $id, function ($args, $next) {
            return $next($this->_model::destroy($args));
        });
    }
}
