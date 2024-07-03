<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nomer_induk' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'kelas' => 'required|integer',
            'roles.*'  => ['integer',],
            'roles'    => ['required','array',],
        ];
    }
}
