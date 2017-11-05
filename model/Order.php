<?php

namespace Models;

/**
 * Class containing methods and attributes of Order
 *
 * @author Artur Ferreira
 */
class Order {

    private $id;
    private $customer_id;
    private $items;
    private $total;

    public function __construct($id, $customer_id, $items, $total) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->items = $items;
        $this->total = $total;
    }

    public function getId() {
        return $this->id;
    }

    public function getCustomer_id() {
        return $this->customer_id;
    }

    public function getItems() {
        return $this->items;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCustomer_id($customer_id) {
        $this->customer_id = $customer_id;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

}
