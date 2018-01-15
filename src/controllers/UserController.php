<?php

namespace src\controllers;

require_once __DIR__.'/../interfaces/CrudOps.php';
require_once __DIR__.'/../db/DB.php';
require_once __DIR__.'/../controllers/Auth.php';




use src\interfaces\CrudOps;

use src\db\DB;

class UserController implements CrudOps
{
    use Auth;

    public function create($data)
    {
        $errors = [];
        if (!is_array($data)){
            array_push($errors, "parameter must be an array");
        }
        if (!array_key_exists("username", $data)){
            array_push($errors, "username key missing in data passed");
        }
        if (!array_key_exists("password",$data)){
            array_push($errors, "password key missing in data passed");
        }

        if (sizeof($errors) == 0) {

            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("INSERT INTO users(username, password, user_type)
                          VALUES (:username, :password, :user_type)");
                $stmt->bindParam(":username", $data['username']);
                $stmt->bindParam(":password", password_hash($data['password'], PASSWORD_BCRYPT));
                $stmt->bindParam(":user_type", $data['user_type']);
                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "User Account created successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to create user account"
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
        else{
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
        if (!is_array($data)){
            array_push($errors, "parameter must be an array");
        }
        if (!array_key_exists("username", $data)){
            array_push($errors, "username key missing in data passed");
        }
        if (!array_key_exists("password",$data)){
            array_push($errors, "password key missing in data passed");
        }
        if (!is_int($id)){
            array_push($errors, "id not an integer");
        }

        if (sizeof($errors)==0){

        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("UPDATE  users SET username=:username, password=:password, user_type=:user_type
                          WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":password", bcrypt($data['password'], PASSWORD_BCRYPT));
            $stmt->bindParam(":user_type", $data['user_type']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "User Account updated successfully"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to update user account"
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
        if (is_int($id)){
        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("DELETE FROM users WHERE  id=:id");
            $stmt->bindParam(":id", $id);

            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "User Account deleted"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to delete user account"
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
        if (is_int($id)){
        try {

            $db = new DB();
            $stmt = $db->connect()
                ->prepare("SELECT t.* FROM users t WHERE  t.id=:id");
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
                ->prepare("SELECT t.* FROM users t WHERE  t.id=:id");
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