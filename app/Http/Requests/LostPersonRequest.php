<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LostPersonRequest extends FormRequest
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
     *     schema="LostPersonRequest",
     *     type="object",
     *     required={"region"},
     *     @OA\Property(
     *         property="firstName",
     *         type="string",
     *         description="The first name of the lost person"
     *     ),
     *     @OA\Property(
     *         property="lastName",
     *         type="string",
     *         description="The last name of the lost person"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         description="The email address of the person reporting the lost person"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         description="The phone number of the person reporting the lost person"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the lost person"
     *     ),
     *     @OA\Property(
     *         property="voiceMessage",
     *         type="string",
     *         format="binary",
     *         description="The voice message related to the lost person"
     *     ),
     *     @OA\Property(
     *         property="file",
     *         type="string",
     *         format="binary",
     *         description="The file attached to the lost person report"
     *     ),
     *     @OA\Property(
     *         property="region",
     *         type="string",
     *         description="The region where the person was lost"
     *     ),
     *     @OA\Property(
     *         property="date",
     *         type="string",
     *         format="date",
     *         description="The date when the person was lost"
     *     ),
     *          @OA\Property(
     *          property="nationality",
     *          type="string",
     *          description="The gender of the lost person"
     *      ),
     *          @OA\Property(
     *          property="age",
     *          type="string",
     *          description="The age of the lost person"
     *      ),
     *          @OA\Property(
     *          property="notificationSender",
     *          type="string",
     *          description="The person who submitted the request"
     *      ),
     *           @OA\Property(
     *           property="gender",
     *           type="string",
     *           description="The gender of lost person"
     *       )
     * )
     */
    public function rules(): array
    {
        return [
            'firstName' => 'nullable|string',
            'lastName' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'description' => 'nullable|string',
//            'voiceMessage' => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav',
            'file' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,video/mp4,video/mpeg,video/quicktime',
            'region' => 'nullable',
            'date' => 'nullable|date',
            'notificationSender' => 'nullable',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'nationality' => 'nullable|string',
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
