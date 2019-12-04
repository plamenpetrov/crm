<?php

namespace App\Http\Response;

/**
 * Transform API response
 *
 * @author PACO
 */
abstract class Transformer {

    /**
     * Call this method to transform Eloquent model
     * @param array $items
     * @return type
     */
    public function transformCollection(array $items) {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * Implement this method at any child class to transform each item/items
     */
    public abstract function transform($item);
}
