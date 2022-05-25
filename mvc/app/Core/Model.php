<?php

namespace app\Core;

use app\Core\DB;

abstract class Model {
    
    public $pdo;
    // protected $table;

    public function __construct() {
        $this->pdo = new DB;
    }

}