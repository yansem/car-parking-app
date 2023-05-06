<?php

namespace App\Http\Requests;

use App\Models\Parking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParkingUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'parking_id' => ['required', 'integer'],
            'price' => ['required', Rule::in(Parking::find($this->parking_id)->total_price)]
        ];
    }
}
