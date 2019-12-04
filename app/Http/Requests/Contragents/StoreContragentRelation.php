<?php

namespace App\Http\Requests\Contragents;

use App\Http\Requests\BaseRequest;

class StoreContragentRelation extends BaseRequest {

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
                        'contragentid' => 'required|integer|exists:contragents,id|different:relationid',
                        'relationid' => 'required|integer|exists:contragents,id',
                    ];
                }
            case 'DELETE': {
                    return [
//                        'id' => 'required|integer',
                        'contragentid' => 'required|integer|exists:contragents,id',
                        'relationid' => 'required|integer|exists:contragents,id',
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
            'contragentid.different' => \Translate::translate('validation=>contragentrelationiddifferent'),
            'relationid.required' => \Translate::translate('validation=>relatedcontragentid'),
            'relationid.integer' => \Translate::translate('validation=>relatedcontragentid'),
        ];
    }

}
