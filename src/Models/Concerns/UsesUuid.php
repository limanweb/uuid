<?php

namespace Limanweb\Uuid\Models\Concerns;

use Limanweb\Uuid\Support\Uuid as CustomUuid;

/**
 * @desc Use this trait in models with UUID primary key
 */
trait UsesUuid
{
    /**
     * Registering handler for "creating" event. 
     */
    protected static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = CustomUuid::genUuid($model->getEntityCode(), $model->getAppCode());
            }
        });
    }
 
    /**
     * 
     * @return boolean
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * 
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
    
    /**
     * Retrieves model application code
     * 
     * @return integer
     */
    public function getAppCode()
    {
        return $this->appCode;
    }
    
    /**
     * Retrieves model entity code
     * 
     * @return integer
     */
    public function getEntityCode()
    {
        return $this->entityCode;
    }

}