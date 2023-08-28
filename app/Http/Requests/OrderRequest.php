<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomException;
use Illuminate\Contracts\Validation\Validator;

class OrderRequest extends FormRequest
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
                    'client_name' => 'required|string|max:255',
                    'status' => 'required|string|max:255',
                    'details' => 'array', 
                    'details.*.recipe_id' => 'required|exists:recipes,id',
                    'details.*.quantity' => 'required|integer|min:1',
                    'details.*.comments' => 'nullable|string',
                ];
            case 'PUT':
                return [
                    'status' => 'required|string|max:255',
                ];
          }
          return [
              //
          ];
    }
    

    protected function failedValidation(Validator $validator)
    {
        throw new CustomException('Unprocessable Request.', 422);
    }
}
