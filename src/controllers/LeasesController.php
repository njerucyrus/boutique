<?php
namespace src\controllers;

require_once __DIR__.'/../interfaces/CrudOps.php';
require_once __DIR__.'/../db/DB.php';

use src\interfaces\CrudOps;

class LeasesController implements CrudOps{
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function getId($id)
    {
        // TODO: Implement getId() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

}