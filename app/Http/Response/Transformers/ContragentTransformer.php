<?php

namespace App\Http\Response\Transformers;

use App\Http\Response\Transformer as Transformer;

/**
 * Description of ContragentTransformer
 *
 * @author PACO
 */
class ContragentTransformer extends Transformer {

    /**
     * Transform each contragent to acceptable client response
     * @param type $item
     * @return type
     */
    public function transform($item) {
        return [
            'transfContragentEIK' => $item['contragentEIK']
        ];
    }

}
