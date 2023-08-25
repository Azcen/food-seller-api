<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                'name' => 'required|string',
                'type' => 'required|string',
                'ingredients' => 'array', 
                'ingredients.*.id' => 'required|exists:ingredients,id', 
                'ingredients.*.quantity' => 'required|numeric|min:0', 
                'price' => 'required|numeric',
                'description' => 'required|string',
                ];
            case 'PUT':
                return [
                    'name' => 'required|string',
                    'type' => 'required|string',
                    'ingredients' => 'array', 
                    'ingredients.*.id' => 'required|exists:ingredients,id', 
                    'ingredients.*.quantity' => 'required|numeric|min:0', 
                    'price' => 'required|numeric',
                    'description' => 'required|string',
                ];
          }
          return [
              //
          ];
    }
}
