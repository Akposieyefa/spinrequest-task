<?php

namespace App\Traits;

trait UsesUuidTrait
{
    protected static function bootUsesUuidTrait(): void
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) str()->uuid();
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
    
}
