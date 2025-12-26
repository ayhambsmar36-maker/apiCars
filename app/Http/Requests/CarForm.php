<?php

namespace App\Http\Requests;

use App\helper\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarForm extends FormRequest
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
    {    if ($this->isMethod('POST')) {
        return [
            'name' => 'required|string|max:40',
            'model' => 'required|string',
            'year' => 'required|numeric',
            'price' => 'required|numeric',
            'engine' => 'required|string',
            'description' => 'required|string',
            'fuel' => 'required|string',
            'transmission' => 'required|string',
            'brand' => 'required|min:3|max:20|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

        ];
    }
    else if($this->isMethod('put') ||$this->isMethod('patch') ) {
        return [
            'name' => 'sometimes|string|max:40',
            'model' => 'sometimes|string',
            'year' => 'sometimes|numeric',
            'price' => 'sometimes|numeric',
            'engine' => 'sometimes|string',
            'description' => 'sometimes|string',
            'fuel' => 'sometimes|string',
            'transmission' => 'sometimes|string',
            'brand' => 'sometimes|min:3|max:20|string',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

        ];
    }
    return [];
    }

    /* public function messages(){

        return Api::responseApi(400,[
         "details of cars"=>"price,name,model,year,description,type of fuel and transmission is required",
         "images"=>"required and every image is smaller than 2 mega byte "
        ],[]);
     }*/
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {

        throw new HttpResponseException(Api::responseApi(400,
         [
        'details of cars' => 'price,name,model,year,description,type of fuel and transmission is required',
          'images' => 'required and every image is smaller than 2 mega byte'
        ],
          []));
    }
}
