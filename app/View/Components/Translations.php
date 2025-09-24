<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Translations extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $locale = Session::get('locale');

        $translations = Cache::rememberForever('translations_' . $locale, function () use ($locale) {
            $jsonTranslations = [];

            if (File::exists(lang_path($locale . '.json'))) {
                $jsonTranslations = json_decode(File::get(lang_path($locale . '.json')), true);
            }

            return $jsonTranslations;
        });

        return view('components.translations', [
            'translations' => $translations,
        ]);
    }
}
