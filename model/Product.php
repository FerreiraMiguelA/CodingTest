<?php

namespace Models;

/**
 * Class containing methods and attributes of Product
 *
 * @author Artur Ferreira
 */
class Product {

    private $id;
    private $description;
    private $category;
    private $price;

    public function __construct($id, $description, $category, $price) {
        $this->id = $id;
        $this->description = $description;
        $this->category = $category;
        $this->price = $price;
    }

    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function getCategory() {
        return $this->category;
    }

    function getPrice() {
        return $this->price;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setPrice($price) {
        $this->price = $price;
    }

}
