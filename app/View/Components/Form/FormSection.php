<?php
/*
 * Copyright (C) 2021,  Chistel Brown,  - All Rights Reserved
 * @project                  courier
 * @file                           FormSection.php
 * @author                  Chistel Brown
 * @site                          <http://twitter.com/chistelbrown>
 * @email                      chistelbrown@gmail.com
 * @lastmodified     08/06/2021, 1:08 PM
 */

namespace App\View\Components\Form;

use Illuminate\View\Component;

class FormSection extends Component
{
    /**
     * @var mixed|string
     */
    public $method;
    /**
     * @var mixed|null
     */
    public $action;
    /**
     * @var mixed|string
     */
    public $title;
    /**
     * @var mixed|null
     */
    public $formencoding;

    /**
     * Create the component instance.
     *
     * @param string $method
     * @param null $action
     * @param null $formencoding
     * @param string $title
     */
    public function __construct($method = 'post',$action = null, $formencoding = null, $title = '')
    {
        $this->method = $method;

        $this->action = $action;

        $this->title =  $title;

        $this->formencoding = $formencoding;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.form-section');
    }
}
