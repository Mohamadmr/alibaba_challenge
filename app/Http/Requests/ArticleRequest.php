<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'content' => ['required', 'required', 'max:1000'],
            'publication_date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
