<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssistanceDemandRequest extends FormRequest
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
     *     schema="AssistanceDemandRequest",
     *     type="object",
     *     required={"firstName", "lastName", "phone", "assistanceType"},
     *     @OA\Property(
     *         property="firstName",
     *         type="string",
     *         description="The first name of the person requesting assistance"
     *     ),
     *     @OA\Property(
     *         property="lastName",
     *         type="string",
     *         description="The last name of the person requesting assistance"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         description="The email address of the person requesting assistance"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         description="The phone number of the person requesting assistance"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the assistance request"
     *     ),
     *     @OA\Property(
     *         property="voiceMessage",
     *         type="string",
     *         format="binary",
     *         description="The voice message related to the assistance request"
     *     ),
     *     @OA\Property(
     *         property="file",
     *         type="string",
     *         format="binary",
     *         description="The file attached to the assistance request"
     *     ),
     *     @OA\Property(
     *         property="assistanceType",
     *         type="string",
     *         description="The type of assistance requested"
     *     )
     * )
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'email',
            'phone' => 'required|numeric',
            'description' => 'nullable|string',
//            'voiceMessage' => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,audio/m4a',
            'file' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,video/mp4,video/mpeg,video/quicktime',
            'assistanceType' => 'required',
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
