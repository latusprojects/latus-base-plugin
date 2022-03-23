<?php

namespace Latus\BasePlugin\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Latus\BasePlugin\Rules\PermalinkCanBeSet;

class UpdatePageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'text' => 'present',
            'permalink' => [
                'required', 'string', 'min:3', 'max:255', new PermalinkCanBeSet($this->page)
            ]
        ];
    }
}