<?php

namespace App\Http\Requests;

class ReplyCreateRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|string|min:4'
        ];
    }
}
