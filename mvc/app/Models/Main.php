<?php

namespace app\Models;

use app\Core\Model;

class Main extends Model {

    public function getAll() {
        return $this->pdo->row('SELECT * FROM contacts ORDER BY last_name ASC, first_name ASC');
    }

    public function addItem($request) {
        $params = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'comments' => $request['comments']
        ];

        $this->pdo->query('INSERT INTO contacts(first_name, last_name, phone, comments) VALUES (:first_name, :last_name, :phone, :comments)', $params);

        return $this->pdo->lastInsertId();
    }

}