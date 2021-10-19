<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Regis extends ResourceController
{
  use ResponseTrait;
  protected $modelName = 'App\Models\Regis';
  protected $format = 'json';

  // get all restaurant
  public function index()
  {
    $data = $this->model->findAll();
    return $this->respond($data);
  }

  
  public function create()
  {
    $uuid = service('uuid');
    $param = [
      'regis_id' => $uuid->uuid4()->toString(). "-regis",
      'category_id' => $this->request->getVar('category_id'),
      'member_id' => $this->request->getVar('member_id')
    ];

    $this->model->insert($param);
    $data = $this->model->find($param['regis_id']);
    return $this->respond($data);
  }

}
