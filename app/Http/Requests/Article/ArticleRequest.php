<?php

namespace App\Http\Requests\Article;

use App\Abstracts\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|min:5',
            'body' => 'required',
        ];
    }
}
