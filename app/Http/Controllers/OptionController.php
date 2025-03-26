<?php

namespace App\Http\Controllers;

use App\Services\OptionService;

class OptionController extends Controller
{
    public function index(OptionService $optionService)
    {
        // Test getting an option
        $siteTitle = $optionService->get('blogname', 'Default Title');

        // Test updating an option
        $optionService->update('test_option', ['foo' => 'bar'], 'yes');

        // Test adding a new option
        $optionService->add('new_option', 'Hello World', 'no');

        // Test getting all autoloaded options
        $autoloaded = $optionService->getAutoloaded();

        return view('options.index', [
            'siteTitle' => $siteTitle,
            'testOption' => $optionService->get('test_option'),
            'newOption' => $optionService->get('new_option'),
            'autoloaded' => $autoloaded,
        ]);
    }
}