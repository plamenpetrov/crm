<?php

namespace App\Http\Requests\Person;

use App\Http\Requests\BaseRequest;

class StorePerson extends BaseRequest {

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
                        'personfirstname' => 'required|max:255',
                        'personfamilyname' => 'required|max:255',
                        'personaddressidcard' => 'required|max:500',
                        'personmailingaddress' => 'required|max:500',
                        'personidentificationnumber' => 'required|max:20|unique:persons,identification_number',
                        'personemail' => 'required|email',
                        'personphone' => 'required|max:100',
                        'personidcard' => 'required|max:20',
                        'personidcarddateofissue' => 'required|date',
                        'personidcarddateofexpiry' => 'required|date',
                        'personpublishedby' => 'required|integer|exists:settlement,id',
                        'personnote' => 'max:500',
                    ];
                }
            case 'PATCH': {
                    return [
                        'id' => 'required|integer',
                        'personfirstname' => 'required|max:255',
                        'personfamilyname' => 'required|max:255',
                        'personaddressidcard' => 'required|max:500',
                        'personmailingaddress' => 'required|max:500',
                        'personidentificationnumber' => 'required|max:20|unique:persons,identification_number,' . $this->id,
                        'personemail' => 'required|email',
                        'personphone' => 'required|max:100',
                        'personidcard' => 'required|max:20|unique:persons,idcard,' . $this->id,
                        'personidcarddateofissue' => 'required|date',
                        'personidcarddateofexpiry' => 'required|date',
                        'personpublishedby' => 'required|integer|exists:settlement,id',
                        'personnote' => 'max:500',
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
            'personfirstnname.required' => \Translate::translate('validation=>personfirstnname'),
            'personfirstnname.max' => \Translate::translate('validation=>personfirstnname.max'),
            'personfamily.required' => \Translate::translate('validation=>personfamily'),
        ];
    }

}
