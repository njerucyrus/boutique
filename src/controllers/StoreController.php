<?php

namespace src\controllers;

require_once __DIR__ . '/../interfaces/CrudOps.php';
require_once __DIR__ . '/../db/DB.php';

require_once __DIR__ . '/../interfaces/CrudOps.php';
require_once __DIR__ . '/../db/DB.php';

use src\interfaces\CrudOps;
use src\db\DB;

class StoreController implements CrudOps
{
    public function create($data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("store_name", $data)) {
            array_push($errors, "store_name key missing in data passed");
        }

        if (!array_key_exists("address", $data)) {
            array_push($errors, "address key missing in data passed");
        }

        if (sizeof($errors) == 0) {

            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("INSERT INTO stores(store_name, address)
                          VALUES (:store_name, :address)");
                $stmt->bindParam(":store_name", $data['store_name']);
                $stmt->bindParam(":address", $data['address']);
                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Store added successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to add Store"
                    ];
                }

            } catch (\PDOException $e) {
                $e->getMessage();
                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => $errors
            ];
        }
    }

    public function update($id, $data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("store_name", $data)) {
            array_push($errors, "store_name key missing in data passed");
        }

        if (!array_key_exists("address", $data)) {
            array_push($errors, "address key missing in data passed");
        }
        if (!is_int($id)){
            array_push($errors, "id not an integer");
        }

        if (sizeof($errors) == 0) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("UPDATE  stores SET store_name=:store_name, address=:address
                          WHERE id=:id");

                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":store_name", $data['store_name']);
                $stmt->bindParam(":address", $data['address']);
                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Store updated successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed , Store not  updated"
                    ];
                }

            } catch (\PDOException $e) {

                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => $errors
            ];
        }
    }

    public function delete($id)
    {
        if (is_int($id)) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("DELETE FROM stores WHERE  id=:id");
                $stmt->bindParam(":id", $id);

                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Store deleted"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to delete store"
                    ];
                }


            } catch (\PDOException $e) {
                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => ["Expects an integer"]
            ];
        }

    }


    public function getId($id)
    {
        if (is_int($id)) {
            try {

                $db = new DB();
                $stmt = $db->connect()
                    ->prepare("SELECT t.* FROM stores t WHERE  t.id=:id");
                $stmt->bindParam(":id", $id);
                $query = $stmt->execute();

                if ($query) {
                    return $stmt->fetch(\PDO::FETCH_ASSOC);

                } else {
                    return [];
                }


            } catch (\PDOException $e) {
                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];
            }
        }else{
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => ["Expects an integer"]
            ];
        }
    }

    public function all()
    {
        try {

            $db = new DB();
            $stmt = $db->connect()
                ->prepare("SELECT t.* FROM stores t");
            $stmt->bindParam(":id", $id);
            $query = $stmt->execute();

            if ($query) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);

            } else {
                return [];
            }


        } catch (\PDOException $e) {
            return [
                "status" => "error",
                "message" => "Exception Error {$e->getMessage()}"
            ];
        }
    }

}