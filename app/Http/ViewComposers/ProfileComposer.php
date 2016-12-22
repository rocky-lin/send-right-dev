<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\User;

class ProfileComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */

    /**
     * Create a new profile composer.
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $view->with('count', 123123);
    }
}