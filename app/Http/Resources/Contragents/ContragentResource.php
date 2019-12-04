<?php

namespace App\Http\Resources\Contragents;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Contragents\ContragentTypeResource;
use App\Http\Resources\Contragents\ContragentOrganizationTypeResource;

class ContragentResource extends Resource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'contragentname' => $this->name,
            'contragentcontactaddress' => $this->contact_address,
            'contragentregistrationaddress' => $this->registration_address,
            'contragentmailingaddress' => $this->mailing_address,
            'contragentEIK' => $this->EIK,
            'contragentDanNom' => $this->DanNom,
            'contragentphone' => $this->phone,
            'contragentemail' => $this->email,
            'contragentsettlementsid' => $this->settlements_id,
            'contragentcountryid' => $this->country_id,
            'createdat' => $this->created_at,
            'updatedat' => $this->updated_at,
            'createdby' => optional($this->createdby)->name,
            'updatedby' => optional($this->updatedby)->name,
//            'contragenttypeid' => $this->company_types_id,
            'contragenttype' => new ContragentTypeResource($this->type),
//            'contragentorganizationtypeid' => $this->company_organization_types_id,
            'contragentorganizationtype' => new ContragentOrganizationTypeResource($this->organizationtype)
            
        ];
    }

    public function with($request) {
        return ['status_code' => 200];
    }

}
