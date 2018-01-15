<?php
/**
 * Created by PhpStorm.
 * User: njerucyrus
 * Date: 1/15/18
 * Time: 4:55 PM
 */

namespace src\controllers;

require_once __DIR__ . '/../interfaces/CrudOps.php';
require_once __DIR__ . '/../db/DB.php';

use src\db\DB;
use src\interfaces\CrudOps;

class CustomerController implements CrudOps
{
    public function create($data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("user_id", $data)) {
            array_push($errors, "user_id key missing in data passed");
        }

        if (!array_key_exists("first_name", $data)) {
            array_push($errors, "first_name key missing in data passed");
        }
        if (!array_key_exists("address", $data)) {
            array_push($errors, "address key missing in data passed");
        }
        if (!array_key_exists("last_name", $data)) {
            array_push($errors, "last_name key missing in data passed");
        }
        if (!array_key_exists("telephone", $data)) {
            array_push($errors, "telephone key missing in data passed");
        }
        if (!array_key_exists("dob", $data)) {
            array_push($errors, "dob key missing in data passed");
        }

        if (sizeof($errors) == 0) {

            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("INSERT INTO customers(user_id, first_name, last_name, address, telephone, dob)
                          VALUES (:user_id, :first_name, :last_name, :address, :telephone, :dob)");

                $stmt->bindParam(":user_id", $data['user_id']);
                $stmt->bindParam(":first_name", $data['first_name']);
                $stmt->bindParam(":last_name", $data['last_name']);
                $stmt->bindParam(":address", $data['address']);
                $stmt->bindParam(":telephone", $data['telephone']);
                $stmt->bindParam(":dob", $data['dob']);

                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Customer Info added successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to add Customer Info {$stmt->errorInfo()[2]}"
                    ];
                }

            } catch (\PDOException $e) {
                $e->getMessage();
                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        }else{
            return [
                "status"=>"error",
                "message"=>"Data validation failed. Access errors key for specific errors",
                "errors" =>$errors
            ];
        }
    }

    public function update($id, $data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("user_id", $data)) {
            array_push($errors, "user_id key missing in data passed");
        }

        if (!array_key_exists("first_name", $data)) {
            array_push($errors, "first_name key missing in data passed");
        }
        if (!array_key_exists("address", $data)) {
            array_push($errors, "address key missing in data passed");
        }
        if (!array_key_exists("last_name", $data)) {
            array_push($errors, "last_name key missing in data passed");
        }
        if (!array_key_exists("telephone", $data)) {
            array_push($errors, "telephone key missing in data passed");
        }
        if (!array_key_exists("dob", $data)) {
            array_push($errors, "dob key missing in data passed");
        }
        if (!is_int($id)) {
            array_push($errors, "id not and integer");
        }

        if (sizeof($errors) == 0) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("UPDATE  customers SET user_id=:user_id, first_name=:first_name,
                          last_name=:last_name, address=:address, telephone=:telephone, dob=:dob
                          WHERE id=:id");

                $stmt->bindParam(":id", $id);

                $stmt->bindParam(":user_id", $data['user_id']);
                $stmt->bindParam(":first_name", $data['first_name']);
                $stmt->bindParam(":last_name", $data['last_name']);
                $stmt->bindParam(":address", $data['address']);
                $stmt->bindParam(":telephone", $data['telephone']);
                $stmt->bindParam(":dob", $data['dob']);

                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Customer Info updated successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed , Customer not  updated {$stmt->errorInfo()}"
                    ];
                }

            } catch (\PDOException $e) {

                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        }else{
            return [
                "status"=>"error",
                "message"=>"Data validation failed. Access errors key for specific errors",
                "errors" =>$errors
            ];
        }
    }

    public function delete($id)
    {
        if (is_int($id)) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("DELETE FROM customers WHERE  id=:id");
                $stmt->bindParam(":id", $id);

                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Customer deleted"
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
        }else{
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
            $sql = "SELECT username, first_name, last_name, address, telephone,dob
                FROM customers INNER JOIN users on users.id = customers.user_id WHERE customers.id='{$id}'";

            try {
                $db = new DB();
                $stmt = $db->connect()
                    ->prepare($sql);
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
            $sql = "SELECT username, first_name, last_name, address, telephone,dob
                FROM customers INNER JOIN users ON users.id = customers.user_id";
            $stmt = $db->connect()
                ->prepare($sql);
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