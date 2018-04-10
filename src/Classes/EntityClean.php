<?php

namespace Web64\Client\Classes\EntityClean;

class EntityClean
{
	protected $entity;

    public function handle( $entity )
    {
        $this->entity = $entity;


        return $this->entity;
    }


}