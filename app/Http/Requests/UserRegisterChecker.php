<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UserRegisterChecker extends FormRequest
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
            "name" => ["required", "unique:users", "max:50"],
            "email" => ["required", "regex:/(.+)@(.+)\.(.+)/i", "unique:users"],
            "password" => ["required", Password::min(3)
                ->letters()
                ->numbers()
                ->mixedCase()
                ->symbols(),
                //->uncompromised(),
                "confirmed"
            ],
            "password_confirmation" => "required"
        ];
    }

    public function messages(){
        return [
            "name.required" => "Név elvárt",
            "name.max" => "Túl hosszú név",
            "email.required" => "Email elvárt",
            "email.regex" => "Nem valós email cím",
            "email.unique" => "Már létező email cím",
            "password.required" => "Jelszó elvárt",
            "password.min" => "Túl rövid jelszó",
            "password.letters" => "Legalább egy betű",
            "password.numbers" => "Legalább egy szám",
            "password.mixed" => "Kis és nagybetű",
            "password.symbols" => "Legalább egy különleges karakter",
            "password.confirmation.required" => "Jelszó megerősítés elvárt",
            "password.confirmed" => "Nem egyező jelszó",
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "message" => "Adatbeviteli hiba",
            "data" => $validator->errors()
        ]));
    }
}
