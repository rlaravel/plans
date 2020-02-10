<?php

namespace MorenoRafael\Plans\Presenters;

use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}