<?php

namespace MorenoRafael\Plans\Presenters;

use Illuminate\Support\HtmlString;

class PlanSubscriptionPresenter extends Presenter
{
    /**
     * @return HtmlString
     */
    public function isActive()
    {
        if (is_null($this->model->canceled_at) && is_null($this->model->canceled_immediately)) {
            return new HtmlString('<span class="badge badge-success">Activo</span>');
        }
    }

    /**
     * @return HtmlString
     */
    public function isOnTrial()
    {
        if (!is_null($this->model->trial_ends_at) && $this->model->trial_ends_at > now()) {
            return new HtmlString('<span class="badge badge-warning">En Prueba</span>');
        }
    }

    /**
     * @return HtmlString
     */
    public function isCanceled()
    {
        if (!is_null($this->model->canceled_at) || !is_null($this->model->canceled_immediately)) {
            return new HtmlString('<span class="badge badge-danger">Cancelado</span>');
        }
    }

    /**
     * @return HtmlString
     */
    public function isEnded()
    {
        if ($this->model->ends_at < now()) {
            return new HtmlString('<span class="badge badge-danger">Cancelado</span>');
        }
    }
}