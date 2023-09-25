<?php

namespace App\Http\Requests;

use App\Traits\ResponseApi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RequestRegister extends FormRequest
{
    use ResponseApi;
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
            'name' => 'required|min:3',
            'email' => 'nullable|min:5',
            'phone' => 'nullable|min:7|numeric',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password|min:6',
        ];
        
    }


    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.min' => 'Email minimal harus memiliki 5 karakter',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain',
            'phone.min' => 'Nomor telepon minimal harus memiliki 7 karakter',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.unique' => 'Nomor telepon sudah terdaftar, silakan gunakan nomor telepon lain',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal harus memiliki 6 karakter',
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password',
            'password_confirmation.min' => 'Konfirmasi password minimal harus memiliki 6 karakter',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requestValidation($validator->errors()->toArray(), 'Failed!'));
    }
}
