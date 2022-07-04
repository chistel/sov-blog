<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           Dropdown.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\View\Components\General;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class Modal
 *
 * @package App\View\Components\General
 */
class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string|null $id
     * @param string|null $maxWidth
     */
    public function __construct(
        public string|null $id = null,
        public string|null $maxWidth = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.general.modal');
    }
}
