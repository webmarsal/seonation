<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessUtmBuilderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'url' => ['required', 'url', 'min:1', 'max:2048'],
            'source' => ['required', 'min:1', 'max:128', 'alpha_dash'],
            'medium' => ['max:128', 'alpha_dash'],
            'campaign' => ['max:128', 'alpha_dash'],
            'term' => ['max:128', 'alpha_dash'],
            'content' => ['max:128', 'alpha_dash']
        ];
    }
}
