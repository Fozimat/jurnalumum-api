<?php

namespace App\Http\Controllers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Generator;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;
use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

class ScrambleDocsController extends Scramble
{

    public static function registerUiRoute(string $path, string $api = 'default'): Route
    {
        $config = static::getGeneratorConfig($api);

        return RouteFacade::get($path, function (Generator $generator) use ($api) {
            $config = static::getGeneratorConfig($api);

            return view('scramble.docs', [
                'spec' => $generator($config),
                'config' => $config,
            ]);
        })
            ->middleware($config->get('middleware', [RestrictedDocsAccess::class]));
    }
}
