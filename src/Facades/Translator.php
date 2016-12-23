<?php namespace EugeneBunin\Translator\Facades;

use Illuminate\Support\Facades\Facade;

class Translator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'translator';
    }
}
