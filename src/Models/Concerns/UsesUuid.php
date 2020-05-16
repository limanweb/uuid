<?php

namespace Limanweb\Uuid\Models\Concerns;

use Limanweb\Uuid\Support\Uuid as CustomUuid;

/**
 * @desc Use this trait in models with UUID primary key
 */
trait UsesUuid
{
    /**
     * 
     */
    protected static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = CustomUuid::genUuid($model->entityCode, $model->appCode);
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
}