<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createEmpleadosRequest extends FormRequest
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
            'nombre'=> 'required|string|max:1000',
            'puesto'=>'max:100'
            //
        ];
    }

    public function messages()
    {
        return [
            'nombre.required'=>'El nombre de la marca es requerido2',
            'nombre.max:30'=>'El nombre no puede exceder 30 caracteres',
            'nombre.string'=>'El nombre no deben de ser solamente numeros',
            'puesto.max:100'=>'La descripcion no debe de excceder de 100 caracteres'
        ];
    }
}
