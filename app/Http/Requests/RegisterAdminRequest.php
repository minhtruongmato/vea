<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ Tên không được trống',
            'email.required' => 'Email không được trống',
            'email.email' => 'Định dạng Email không đúng',
            'email.unique' => 'E-Mail đã tồn tại',
            'password.required' => 'Mật Khẩu không được trống',
            'password.confirmed' => 'Xác Nhận Mật Khẩu và Mật Khẩu không khớp',
            'password.min' => 'Mật Khẩu phải nhiều hơn :min'
        ];
    }
}
