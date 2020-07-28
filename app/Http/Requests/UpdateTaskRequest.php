<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'name' => 'required|unique:tasks|max:255' . $this->id,
            'description' => 'string|nullable|max:255',
            'status_id' => 'required|exists:task_statuses,id' . $this->id,
            'assigned_to_id' => 'nullable|exists:users,id' . $this->id,
            'labels' => 'array|nullable'
        ];
    }
}
