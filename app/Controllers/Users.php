<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class User extends ResourceController
{
  use ResponseTrait;
  protected $modelName = 'App\Models\User';
  protected $format = 'json';

  // get all restaurant
  public function index()
  {
    $data = $this->model->findAll();
    return $this->respond($data);
  }


}
