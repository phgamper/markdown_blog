<?php

abstract class View
{
    protected $model;
    protected $entity;

    public function __construct(IModel $model)
    {
        $this->model = $model;
        $this->entity = $model->getEntity();
    }

    public abstract function show();
}

?>