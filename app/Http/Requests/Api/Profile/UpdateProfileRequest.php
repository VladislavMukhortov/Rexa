<?php

namespace App\Http\Requests\Api\Profile;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nickname' => ['required', 'string', 'max:20'],
            'first_name' => ['filled', 'string', 'max:20'],
            'lang' => ['required', Rule::in(config('app.locales'))],
        ];
    }
}
