<?php

namespace Models;

/**
 * Class containing methods and attributes of Customer
 *
 * @author Artur Ferreira
 */
class Customer {

    private $id;
    private $name;
    private $since;
    private $revenue;

    public function __construct($id, $name, $since, $revenue) {
        $this->id = $id;
        $this->name = $name;
        $this->since = $since;
        $this->revenue = $revenue;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSince() {
        return $this->since;
    }

    function getRevenue() {
        return $this->revenue;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSince($since) {
        $this->since = $since;
    }

    function setRevenue($revenue) {
        $this->revenue = $revenue;
    }

}
