<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuriesRequest extends FormRequest
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
            'name' => 'required',
            'is_master' => 'required',
            'last_isal_exchange' => 'required|integer|min:0',
            'last_isal_collect' => 'required|integer|min:0',
            'active' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الخزنة مطلوب',
            'is_master.required' => 'نوع الخزنة مطلوب',
            'last_isal_exchange.required' => 'آخر رقم إيصال صرف نقدية لهذه الخزنة مطلوب',
            'last_isal_exchange.integer' => 'يجب أن تكون قيمة هذا الحقل رقم صحيح',
            'last_isal_collect.required' => 'آخر رقم إيصال تحصيل نقدية لهذه الخزنة مطلوب',
            'last_isal_collect.integer' => 'يجب أن تكون قيمة هذا الحقل رقم صحيح',
            'active.required' => 'التفعيل مطلوب',

        ];
    }
}
