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
    }

    public function update($id, $data)
    {
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
    }

    public function delete($id)
    {
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
    }

    public function getId($id)
    {
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