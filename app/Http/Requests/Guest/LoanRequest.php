<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            "montant_du_pret" => ["required", "string"],
            "monnaie_locale" => ["required", "exists:currencies,id"],
            "duree_du_pret" => ["required", "string"],
            "prenom" => ["required", "string"],
            "nom" => ["required", "string"],
            "adresse_email" => ["required", "email"],
            "sexe" => ["required", "string"],
            "pays_residence" => ["required", "exists:countries,id"],
            "region" => ["required", "string"],
            "adresse_complete" => ["required", "string"],
            "numero_telephone" => ["required", "string", "phone_number"],
        ];
    }
}
