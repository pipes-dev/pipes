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
    protected $_shouldPaginate = true;

    /**
     * index
     *
     */
    public function index()
    {
        $namespace = $this->_model::getNameSpace();
        return Stream::send("$namespace:index", [$this->model], function ($model, $next) {
            if ($this->_shouldPaginate) {
                return $next($model->paginate());
            }
            return $next($model->get());
        });
    }

    /**
     * show
     *
     */
    public function show($id)
    {
        $namespace = $this->_model::getNameSpace();

        $record = $this->model->find($id);

        return Stream::send("$namespace:show", $record);
    }

    /**
     * update
     *
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
     */
    public function store($data)
    {
        $namespace = $this->_model::getNameSpace();

        return Stream::send("$namespace:store", $data, function ($args, $next) {
            return $next($this->model->create($args));
        });
    }

    /**
     * destroy
     *
     */
    public function destroy($id)
    {
        $namespace = $this->_model::getNameSpace();

        return Stream::send("$namespace:destroy", $id, function ($args, $next) {
            return $next($this->model->create($args));
        });
    }
}
