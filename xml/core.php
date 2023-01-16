<?php

function exists(int $id): bool
{
    $pdo = new Database();
    $stmt = $pdo->select(
        'SELECT EXISTS(SELECT * FROM xml_offers WHERE id = :id) as exist',
        [
            'id' =>
            [
                'value' => (int) $id,
                'type' => PDO::PARAM_INT,
            ],
        ]
    );
    return boolval($stmt[0]['exist']);
}

function insert(SimpleXMLElement $object): bool
{
    $pdo = new Database();
    $stmt = $pdo->query('INSERT INTO xml_offers(id, mark, model, generation, model_year, run, color, body_type, engine_type, transmission, gear_type, generation_id)
        VALUES(:id, :mark, :model, :generation, :model_year, :run, :color, :body_type, :engine_type, :transmission, :gear_type, :generation_id)', [
        'id' => [
            'value' => (int) $object->id,
            'type' => PDO::PARAM_INT,
        ],
        'mark' => [
            'value' => (string) $object->mark,
            'type' => PDO::PARAM_STR,
        ],
        'model' => [
            'value' => (string) $object->model,
            'type' => PDO::PARAM_STR,
        ],
        'generation' => [
            'value' => (string) $object->generation,
            'type' => PDO::PARAM_STR,
        ],
        'model_year' => [
            'value' => (int) $object->year,
            'type' => PDO::PARAM_INT,
        ],
        'run' => [
            'value' => (int) $object->run,
            'type' => PDO::PARAM_STR,
        ],
        'color' => [
            'value' => (string) $object->color,
            'type' => PDO::PARAM_STR,
        ],
        'body_type' => [
            'value' => (string) $object->{"body-type"},
            'type' => PDO::PARAM_STR,
        ],
        'engine_type' => [
            'value' => (string) $object->{"engine-type"},
            'type' => PDO::PARAM_STR,
        ],
        'transmission' => [
            'value' => (string) $object->transmission,
            'type' => PDO::PARAM_STR,
        ],
        'gear_type' => [
            'value' => (string) $object->{"gear-type"},
            'type' => PDO::PARAM_STR,
        ],
        'generation_id' => [
            'value' => (int) $object->generation_id,
            'type' => PDO::PARAM_STR,
        ],
    ], true);
    return $stmt;
}

function update(int $id, SimpleXMLElement $object): bool
{
    $pdo = new Database();
    $stmt = $pdo->query('UPDATE xml_offers SET
        mark = :mark,
        model = :model,
        generation = :generation,
        model_year = :model_year,
        run = :run,
        color = :color,
        body_type = :body_type,
        engine_type = :engine_type,
        transmission = :transmission,
        gear_type = :gear_type,
        generation_id = :generation_id
        WHERE id=:id', [
        'id' => [
            'value' => (int) $object->id,
            'type' => PDO::PARAM_INT,
        ],
        'mark' => [
            'value' => (string) $object->mark,
            'type' => PDO::PARAM_STR,
        ],
        'model' => [
            'value' => (string) $object->model,
            'type' => PDO::PARAM_STR,
        ],
        'generation' => [
            'value' => (string) $object->generation,
            'type' => PDO::PARAM_STR,
        ],
        'model_year' => [
            'value' => (int) $object->year,
            'type' => PDO::PARAM_INT,
        ],
        'run' => [
            'value' => (int) $object->run,
            'type' => PDO::PARAM_STR,
        ],
        'color' => [
            'value' => (string) $object->color,
            'type' => PDO::PARAM_STR,
        ],
        'body_type' => [
            'value' => (string) $object->{"body-type"},
            'type' => PDO::PARAM_STR,
        ],
        'engine_type' => [
            'value' => (string) $object->{"engine-type"},
            'type' => PDO::PARAM_STR,
        ],
        'transmission' => [
            'value' => (string) $object->transmission,
            'type' => PDO::PARAM_STR,
        ],
        'gear_type' => [
            'value' => (string) $object->{"gear-type"},
            'type' => PDO::PARAM_STR,
        ],
        'generation_id' => [
            'value' => (int) $object->generation_id,
            'type' => PDO::PARAM_STR,
        ],
    ], true);
    return $stmt;
}

function remove(array $ids): bool
{
    $pdo = new Database();
    $ids = implode(',', $ids);
    $stmt = $pdo->query("DELETE FROM xml_offers WHERE id NOT IN({$ids})", [], true);
    return $stmt;
}
