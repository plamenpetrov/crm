<?php

namespace App\Http\Response\Transformers;

use ContragentTranslatable;

/**
 * Description of ContragentTransformer
 *
 * @author PACO
 */
class ContragentTranslatableTransformer extends TransformerAbstract {

    /**
     * Turn this item object into a generic array.
     *
     * @param  $contragent
     * @return array
     */
    public function transform(ContragentTranslatable $contragent) {
        return [
            'companyname' => $contragent->id,
            'companyaddress' => $contragent->contact_address,
            'companyregistrationaddress' => $contragent->registration_address,
        ];
    }

}
