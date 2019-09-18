<?php

namespace Modules\Opx\MailTemplater;

use Illuminate\Support\Facades\Facade;

/**
 * @method  static string  make($content, $template = 'default')
 * @method  static string  paragraph($text, $classes = null)
 * @method  static string  title($text, $level = 1, $classes = null)
 * @method  static string  anchor($text, $link, $newWindow = true, $classes = null)
 * @method  static string  table(array $table, array $headers = [])
 * @method  static string  name()
 * @method  static string  get($key): ?string
 * @method  static string  path($path = '')
 * @method  static array|string|null  config($key = null)
 * @method  static mixed  view($view)
 */
class OpxMailTemplater extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'opx_mail_templater';
    }
}
