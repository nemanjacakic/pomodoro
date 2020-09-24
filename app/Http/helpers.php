<?php

use App\Http\Repositories\MenuRespository;

function menu($name)
{
    $menuRepo = new MenuRespository();

    $themePath = 'themes/laravel/';

    $data = [
    'menu' => $menuRepo->find('mashine_name', $name)
  ];

    if (view()->exists($themePath . $name)) {
        return view($themePath . $name, $data);
    }

    return view($themePath . 'menu', $data);
}

function settings($key)
{
    $setting = App\Settings::where('key', $key)->first();
    if ($setting === null) {
        throw new \Exception($key.' does not exist in settings');
    }

    return $setting->value;
}

function theme_path()
{
    $setting = App\Settings::where('key', 'active_theme')->first();
    if ($setting === null) {
        throw new \Exception('Active theme is not setting does not exist');
    }

    return 'themes.' . $setting->value;
}
