<?php

namespace App\Http\Requests\Contragents;

use App\Http\Requests\BaseRequest;

class StoreContragent extends BaseRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
//        $comment = Comment::find($this->route('comment'));
//
//        return $comment && $this->user()->can('update', $comment);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        switch ($this->method()) {
            case 'POST': {
                    return [
                        'contragentname' => 'required|max:255',
                        'contragentEIK' => 'required|max:20|unique:companies,EIK',
                        'contragentDanNom' => 'required|max:20',
                        'contactaddress' => 'required|max:500',
                        'registrationaddress' => 'required|max:500',
                        'contragentemail' => 'required|email',
                        'contragentphone' => 'required|max:100',
                        'contragentsettlements' => 'required|integer|exists:settlement,id',
                        'contragentcountry' => 'required|integer|exists:countries,id',
                        'contragentorganizationtype' => 'required|integer|exists:company_organization_types,id',
                        'contragenttype' => 'required|integer|exists:company_types,id',
                    ];
                }
            case 'PATCH': {
                    return [
                        'id' => 'required|integer',
                        'contragentname' => 'required|max:255',
                        'contragentEIK' => 'required|max:20|unique:companies,EIK,' . $this->id,
                        'contragentDanNom' => 'required|max:20',
                        'contactaddress' => 'required|max:500',
                        'registrationaddress' => 'required|max:500',
                        'contragentemail' => 'required|email',
                        'contragentphone' => 'required|max:100',
                        'contragentsettlements' => 'required|integer|exists:settlement,id',
                        'contragentcountry' => 'required|integer|exists:countries,id',
                        'contragentorganizationtype' => 'required|integer|exists:company_organization_types,id',
                        'contragenttype' => 'required|integer|exists:company_types,id',
                    ];
                }
            default:break;
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'contragentname.required' => \Translate::translate('validation=>contragentname'),
            'contragentname.max' => \Translate::translate('validation=>contragentname.max'),
            'contragentcity.required' => \Translate::translate('validation=>contragentcity'),
            'contragentDanNom.required' => \Translate::translate('validation=>contragentDanNom'),
        ];
    }

}
