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
    $sql = "SELECT * 
    FROM ((regis 
    INNER JOIN member ON member.id_card = regis.member_id)
    INNER JOIN category ON category.category_id = regis.category_id     
    )";

    $db = \Config\Database::connect();
    $data = $db->query($sql)->getResultArray();
    return $this->respond($data);
  }

  public function show($category_name = null)
  {
    $sql = "SELECT * 
    FROM ((regis 
    INNER JOIN member ON member.id_card = regis.member_id)
    INNER JOIN category ON category.category_id = regis.category_id     
    ) WHERE category.category_name = ?";

    $db = \Config\Database::connect();
    $data = $db->query($sql, [$category_name])->getResultObject();
    return $this->respond($data);
  }


  public function create()
  {
    $uuid = service('uuid');
    $param = [
      'regis_id' => $uuid->uuid4()->toString() . "-regis",
      'category_id' => $this->request->getVar('category_id'),
      'member_id' => $this->request->getVar('member_id')
    ];

    $this->model->insert($param);
    $data = $this->model->find($param['regis_id']);
    return $this->respond($data);
  }
}
