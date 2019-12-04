<?php

namespace App\Http\Requests\Contragents;

use App\Http\Requests\BaseRequest;

class StoreContragentPerson extends BaseRequest {

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
                        'contragentid' => 'required|integer|exists:contragents,id',
                        'personid' => 'required|integer|exists:persons,id',
                        'comment' => 'max:255',
                    ];
                }
            case 'DELETE': {
                    return [
                        'contragentid' => 'required|integer|exists:contragents,id',
                        'personid' => 'required|integer|exists:persons,id',
                        'comment' => 'max:255',
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
            'contragentid.required' => \Translate::translate('validation=>contragentrelationid'),
            'contragentid.integer' => \Translate::translate('validation=>contragentrelationid'),
            'personid.required' => \Translate::translate('validation=>relatedpersonid'),
            'personid.integer' => \Translate::translate('validation=>relatedpersonid'),
        ];
    }

}
