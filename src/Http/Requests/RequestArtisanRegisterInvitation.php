<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Http\Requests;

use App\Models\User;
use ArtisanCloud\SaaSFramework\Services\ArtisanCloudService;
use ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models\Artisan;
use ArtisanCloud\SaaSFramework\Rules\CodeRule;
use ArtisanCloud\SaaSFramework\Rules\PhoneRule;

use ArtisanCloud\SaaSFramework\Http\Requests\RequestBasic;

use ArtisanCloud\SaaSFramework\Services\CodeService\InvitationCodeService;
use ArtisanCloud\SaaSFramework\Services\CodeService\Models\Code;

use Illuminate\Validation\Rule;

class RequestArtisanRegisterInvitation extends RequestBasic
{
    /**
     * Determine if the artisan is authorized to make this request.
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
//            'countryCode' => 'required',
//            'mobile' => [
//                'required',
//                new PhoneRule(),
//                Rule::unique(User::TABLE_NAME, 'mobile'),
//            ],
//            "name" => "required",
//            "password" => "required|min:6",
//            'invitationEmail' => 'required',
//            'landlordUuid' => 'required',
//            'code' => [
//                'required',
//                new CodeRule(resolve(InvitationCodeService::class), $this->input('invitationEmail') ?? '', Code::TYPE_INVTATION)
//            ],
//            'email' => [
//                'email:rfc,dns',
//                Rule::unique(User::TABLE_NAME, 'email'),
//            ],

        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __("{$this->m_module}.required"),
            'email.required' => __("{$this->m_module}.required"),
            'email.email' => __("{$this->m_module}.email"),
            'invitationEmail.email' => __("{$this->m_module}.email"),
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {

        $validator->after(function ($validator) {

            $arrayTransformedKeys = transformArrayKeysToSnake($this->all());
            $this->replace($arrayTransformedKeys);
//            dd($this);
        });

    }
}
