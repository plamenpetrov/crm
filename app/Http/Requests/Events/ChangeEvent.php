<?php

namespace App\Http\Requests\Events;

use App\Http\Requests\BaseRequest;

class ChangeEvent extends BaseRequest {

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
            case 'PATCH': {
                    return [
                        'id' => 'required|integer',
                        'start_date' => 'required|date_format:Y-m-d H:i',
                        'end_date' => 'required|date_format:Y-m-d H:i',
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
