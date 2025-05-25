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
        return [
            UsersDatabaseColumn::Username->value => 'required|unique:users,username',
            UsersDatabaseColumn::Email->value => 'required|unique:users,email',
            UsersDatabaseColumn::Role->value => 'required',
            UsersDatabaseColumn::NamaLengkap->value => 'required|string|max:255',
            UsersDatabaseColumn::Password->value => 'required|min:8'
        ];
    }
}
