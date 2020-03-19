<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.required' => 'Mật khẩu cũ không được trống',
            'new_password.required' => 'Mật khẩu mới không được trống',
            'new_password_confirmation.required' => 'Xác nhận mật khẩu mới không được trống',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới và Mật khẩu mới không khớp',
            'new_password.min' => 'Mật Khẩu phải nhiều hơn :min',
        ];
    }
}
