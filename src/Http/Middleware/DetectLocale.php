<?php

namespace sinkcup\LaravelLocaleSetter\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;

class DetectLocale
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = '';
        if ($this->app['config']['locale']['default'] == 'header') {
            $first_lang = self::getFirstLang($request->server('HTTP_ACCEPT_LANGUAGE'));
            $locale = self::lang2locale($first_lang, $this->app['config']['locale']['locale_map']);
        }
        if (empty($locale)) {
            $locale = $this->app['config']['app']['fallback_locale'];
        }
        $this->app->setLocale($locale);
        return $next($request);
    }

    /**
     * decode Accept-Language, return first choice.
     * for example: accept-language:zh-CN,zh;q=0.8,zh-TW;q=0.6,zh-HK;q=0.4,en;q=0.2,ja;q=0.2
     * will return zh-CN
     */
    public static function getFirstLang($accept)
    {
        if (empty($accept)) {
            return false;
        }
        $first_lang = $accept;
        if (strpos($accept, ';') !== false) {
            $tmp = explode(';', $accept);
            $accept = $tmp[0];
        }
        if (strpos($accept, ',') !== false) {
            $tmp = explode(',', $accept);
            foreach ($tmp as $one) {
                if (strpos($one, 'q=') !== false) {
                    continue;
                } else {
                    $first_lang = trim($one);
                    break;
                }
            }
        }
        return $first_lang;
    }

    /**
     * convert language to locale. for example: zh-CN to zh_CN, en-US to en_US
     */
    public static function lang2locale($lang, $locale_map)
    {
        if (empty($lang)) {
            return false;
        }
        $locale = str_replace('-', '_', $lang);
        $lower_locale = strtolower($locale);
        if (isset($locale_map[$lower_locale])) {
            $locale = $locale_map[$lower_locale];
        }
        return $locale;
    }
}
