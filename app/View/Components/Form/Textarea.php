<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           Textarea.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{

    public $disabled;

    public $rows;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($disabled = false,$rows = 2)
    {
        $this->disabled = $disabled;

        $this->rows =  $rows;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
