<?php

namespace Botble\Newsletter\Facades;

use Botble\Newsletter\Contracts\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Botble\Newsletter\Contracts\Provider driver(string $driver = null)
 *
 * @see \Botble\Newsletter\NewsletterManager
 */
class Newsletter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
