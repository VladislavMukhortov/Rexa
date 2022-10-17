<?php

namespace App\Http\Requests\Api\Media;

use App\Http\Requests\Api\BaseRequest;

class DefaultAvatarRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => ['required', 'numeric', 'exists:default_avatars,id'],
        ];
    }
}
