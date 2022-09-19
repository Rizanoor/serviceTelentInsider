<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'jobs_title' => 'required|string',
            'location' => 'required|string',
            'workspace_type' => 'required|string',
            'min_salary' => 'required|string',
            'max_salary' => 'required|string',
        ];
    }
}
