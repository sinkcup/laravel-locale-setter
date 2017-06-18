<?php

namespace sinkcup\LaravelLocaleSetterTests\Http\Middleware;

require_once __DIR__ . '/../../../vendor/autoload.php';

use sinkcup\LaravelLocaleSetterTests\TestCase;
use sinkcup\LaravelLocaleSetter\Http\Middleware\DetectLocale;

class DetectLocaleTest extends TestCase
{
    public function testGetFirstLang()
    {
        $header = 'zh-CN,zh;q=0.8,zh-TW;q=0.6,zh-HK;q=0.4,en-US;q=0.2,en;q=0.2,en-GB;q=0.2';
        $first_lang = DetectLocale::getFirstLang($header);
        $this->assertEquals('zh-CN', $first_lang);

        $header = 'zh-CN';
        $first_lang = DetectLocale::getFirstLang($header);
        $this->assertEquals('zh-CN', $first_lang);

        $header = 'cmn-Hans-CN,cmn-Hans';
        $first_lang = DetectLocale::getFirstLang($header);
        $this->assertEquals('cmn-Hans-CN', $first_lang);
    }

    public function testLang2locale()
    {
        $locale = DetectLocale::lang2locale('zh-CN', $this->locale_map);
        $this->assertEquals('zh_CN', $locale);

        $locale = DetectLocale::lang2locale('en-US', $this->locale_map);
        $this->assertEquals('en_US', $locale);

        $locale_map = [
            'zh_cn' => 'cmn_Hans_CN',
            'zh_hk' => 'cmn_Hant_HK',
            'zh_tw' => 'cmn_Hant_TW',
        ];
        $locale = DetectLocale::lang2locale('zh-HK', $locale_map);
        $this->assertEquals('cmn_Hant_HK', $locale);

        $locale = DetectLocale::lang2locale('en-CA', $locale_map);
        $this->assertEquals('en_CA', $locale);
    }
}
