<?php

namespace Clevyr\NovaBlog\Facades;

use Illuminate\Support\Facades\Facade;

class NovaBlog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'NovaBlog';
    }
}
