<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketSearchRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'nullable|numeric|in:1,2,3,4',
            'customer_name' => 'nullable|string',
            'department_id' => 'nullable|numeric|exists:departments,id',
            'offset' => 'nullable|numeric|min:1',
            'limit' => 'nullable|numeric|min:1'
        ];
    }
}
