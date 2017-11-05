<?php

namespace Models;

/**
 * Class containing methods and attributes of Item
 *
 * @author Artur Ferreira
 */
class Item {

    private $product_id;
    private $quantity;
    private $unit_price;
    private $total;

    public function __construct($product_id, $quantity, $unit_price, $total) {
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
        $this->total = $total;
    }

    public function getProduct_id() {
        return $this->product_id;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getUnit_price() {
        return $this->unit_price;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setUnit_price($unit_price) {
        $this->unit_price = $unit_price;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

}
