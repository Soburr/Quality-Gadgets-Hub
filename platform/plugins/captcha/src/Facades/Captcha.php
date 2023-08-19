<?php

namespace Botble\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null display(array $attributes = [], array $options = [])
 * @method static string getJsLink(array $options = [])
 * @method static string displayMultiple(array $options = [])
 * @method static string displayJs(array $options = [], array $attributes = ['async','defer'])
 * @method static void multiple(bool $multiple = true)
 * @method static void setOptions(array $options = [])
 * @method static bool verify(string $response, string|null $clientIp = null, array $options = [])
 *
 * @see \Botble\Captcha\Captcha
 */
class Captcha extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'captcha';
    }
}
