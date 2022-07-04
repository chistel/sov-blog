<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           AuthenticatedLayout.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     13/06/2021, 1:46 PM
 */

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Class AuthenticatedLayout
 * @package App\View\Components\app
 */
class Authenticated extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render()
    {
        return view('layouts.app.authenticated');
    }
}
