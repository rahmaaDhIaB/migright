<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonyRequest extends FormRequest
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

    /**
     * @OA\Schema(
     *     schema="TestimonyRequest",
     *     type="object",
     *     @OA\Property(
     *         property="testimonyType",
     *         type="string",
     *         description="The type of the testimony"
     *     ),
     *     @OA\Property(
     *         property="firstName",
     *         type="string",
     *         description="The first name of the person giving the testimony"
     *     ),
     *     @OA\Property(
     *         property="lastName",
     *         type="string",
     *         description="The last name of the person giving the testimony"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         description="The email address of the person giving the testimony"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         description="The phone number of the person giving the testimony"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the testimony"
     *     ),
     *     @OA\Property(
     *         property="voiceMessage",
     *         type="string",
     *         format="binary",
     *         description="The voice message of the testimony"
     *     ),
     *     @OA\Property(
     *         property="file",
     *         type="string",
     *         format="binary",
     *         description="The file attached to the testimony"
     *     )
     * )
     */
    public function rules(): array
    {
        return [
            'testimonyType' => 'nullable',
            'firstName' => 'nullable|string',
            'lastName' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'description' => 'nullable|string',
//            'voiceMessage' => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav',
            'file' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,video/mp4,video/mpeg,video/quicktime',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->description) && empty($this->voiceMessage)) {
                $validator->errors()->add('description', __('Either description or Voice Message must be filled.'));
            }
        });
    }
}
