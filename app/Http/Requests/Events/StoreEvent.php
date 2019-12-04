<?php

namespace App\Http\Requests\Events;

use App\Http\Requests\BaseRequest;

class StoreEvent extends BaseRequest {

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
                        'eventtype' => 'required|integer|exists:events_types,id',
                        'eventsubtype' => 'required|integer|exists:events_subtypes,id',
                        'eventname' => 'required|max:255',
                        'eventdescription' => 'max:500',
                        'eventlocation' => 'max:500',
                        'eventstartdate' => 'required|date_format:Y-m-d H:i',
                        'eventenddate' => 'date_format:Y-m-d H:i',
                        'eventexecutors' => 'required|array',
                        'eventexecutors.*' => 'integer|exists:users,id'
                    ];
                }
            case 'PATCH': {
                    return [
                        'id' => 'required|integer',
                        'eventtype' => 'required|integer|exists:events_types,id',
                        'eventsubtype' => 'required|integer|exists:events_subtypes,id',
                        'eventname' => 'required|max:255',
                        'eventdescription' => 'max:500',
                        'eventlocation' => 'max:500',
                        'eventstartdate' => 'required|date_format:Y-m-d H:i',
                        'eventenddate' => 'date_format:Y-m-d H:i',
                        'eventexecutors' => 'required|array',
                        'eventexecutors.*' => 'integer|exists:users,id'
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
