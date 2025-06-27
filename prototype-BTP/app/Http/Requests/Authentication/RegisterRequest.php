<?php

namespace App\Http\Requests\Authentication;

use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $username = UsersDatabaseColumn::Username->value;
        $email = UsersDatabaseColumn::Email->value;
        $role = UsersDatabaseColumn::Role->value;
        $namaLengkap = UsersDatabaseColumn::NamaLengkap->value;
        $password = UsersDatabaseColumn::Password->value;

        return [
            $username => 'required|unique:users,username',
            $email => 'required|unique:users,email',
            $role => 'required',
            $namaLengkap => 'required|string|max:255',
            $password => 'required|min:8'
        ];
    }
}
