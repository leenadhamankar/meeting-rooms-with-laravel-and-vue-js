<?php

namespace App\Modules\Meeting\Request;

use App\Http\Requests\Request;

class AddMeetingRequest extends Request
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
            'name' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
            'start_time' => 'required',
            'duration' => 'required',
            'members' => 'required',
            'room_id' => 'required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Meeting name',
            'start_time' => 'Meeting Date Time',
            'duration' => 'Meeting duration',
            'members' => 'No. of members',
            'room_id' => 'Room'
        ];
    }
}
