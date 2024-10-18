<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRevalidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'purchase_code' => ['required', 'string', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'purchase_code.required' => __('validation.required', ['attribute' => __('Purchase Code')]),
            'purchase_code.string'   => __('validation.string', ['attribute' => __('Purchase Code')]),
            'purchase_code.max'      => __('validation.max.string', ['attribute' => __('Purchase Code'), 'max' => 255])
        ];
    }
}
