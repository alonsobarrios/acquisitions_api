<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcquisitionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'budget' => [
                'required',
                'integer',
                'min:1'
            ],
            'unit' => [
                'required',
                'string',
                'max:191'
            ],
            'type' => [
                'required',
                'string',
                'max:191'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'unit_value' => [
                'required',
                'integer',
                'min:1'
            ],
            'date' => [
                'required',
                'date',
            ],
            'supplier' => [
                'required',
                'string',
                'max:191'
            ],
            'documentation' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'budget.required' => "El campo Presupuesto es requerido.",
            'budget.integer' => "El campo Presupuesto debe ser un número entero.",
            'budget.min' => "El campo de Presupuesto debe ser mayor a $0",
            'unit.required' => "El campo Unidad es requerido.",
            'unit.max' => "El campo de Unidad no debe tener más de 190 caracteres.",
            'type.required' => "El campo Tipo es requerido.",
            'type.max' => "El campo de Tipo no debe tener más de 190 caracteres.",
            'quantity.required' => "El campo Cantidad es requerido.",
            'quantity.integer' => "El campo Cantidad debe ser un número entero.",
            'quantity.min' => "El campo de Cantidad debe ser al menos 1",
            'unit_value.required' => "El campo Valor Unitario es requerido.",
            'unit_value.integer' => "El campo Valor Unitario debe ser un número entero.",
            'unit_value.min' => "El campo de Valor Unitario debe ser mayor a $0",
            'date.required' => "El campo Fecha es requerido.",
            'date.date' => "El campo de Fecha debe ser una fecha válida",
            'supplier.required' => "El campo Proveedor es requerido.",
            'supplier.max' => "El campo de Proveedor no debe tener más de 190 caracteres.",
            'documentation.max' => "El campo de Proveedor no debe tener más de 500 caracteres."
        ];
    }
}
