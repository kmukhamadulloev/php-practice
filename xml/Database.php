<?php

class Database
{
    private $pdo = null;

    public function __construct()
    {
        $this->pdo = new PDO(DB_CONN, DB_USER, DB_PASS);
    }

    public function query(string $sql, array $params = [], bool $returnStatus = false): mixed
    {
        $smtp = $this->pdo->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $smtp->bindValue(":{$key}", $val['value'], $val['type']);
            }
        }

        $result = $smtp->execute();

        return $returnStatus ? $result : $smtp;
    }

    public function select(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
