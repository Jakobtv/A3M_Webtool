<?php



namespace App\Model;

class BaseModel {
    public function __construct($query) {
        $this->query = $query;
    }
}