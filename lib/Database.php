<?php

namespace lib;
class Database {
    private $pdo;

    public function __construct() {
$this->pdo = 'da';
    }

    public function getConnection() {
        return $this->pdo;
    }
}

?>