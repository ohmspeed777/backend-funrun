<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Category extends ResourceController
{
  use ResponseTrait;
  protected $modelName = 'App\Models\Category';
  protected $format = 'json';

  // get all restaurant
  public function index()
  {
    $data = $this->model->findAll();
    return $this->respond($data);
  }

  public function show($name = null)
  {
    $data = $this->model->getWhere(['category_name' => $name])->getResult();
    if ($data) {
      return $this->respond($data[0]);
    }
    return $this->failNotFound('Not found user with this id: ' . $name);
  }


  public function create()
  {
    $uuid = service('uuid');
    $param = [
      'category_id' => $uuid->uuid4()->toString() . "-category",
      'category_name' => $this->request->getVar('category_name'),
      'length' => $this->request->getVar('length'),
      'price' => $this->request->getVar('price'),
    ];

    $this->model->insert($param);
    $data = $this->model->find($param['category_id']);
    return $this->respond($data);
  }
}
