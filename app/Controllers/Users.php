<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Users extends ResourceController
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

  public function show($id = null)
  {
    $data = $this->model->getWhere(['id_card' => $id])->getResult();
    if ($data) {
      return $this->respond($data[0]);
    }
    return $this->failNotFound('Not found user with this id: ' . $id);
  }

  public function create()
  {
    $uuid = service('uuid');
    $param = [
      'id_card' => $uuid->uuid4()->toString() . '-' . $this->request->getVar('id'),
      'name' => $this->request->getVar('name'),
      'age' => $this->request->getVar('age'),
      'email' => $this->request->getVar('email'),
      'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
    ];

    $this->model->insert($param);
    $data = $this->model->find($param['id_card']);
    return $this->respond($data);
  }

  public function update($id = null)
  {
    $param = [
      'name' => $this->request->getVar('name'),
      'age' => $this->request->getVar('age'),
      'email' => $this->request->getVar('email'),
    ];

    $this->model->update($id, $param);

    $data = $this->model->find($id);
    return $this->respond($data);
  }

  public function delete($id = null)
  {
    $data = $this->model->find($id);
    if (!$data) {
      return $this->failNotFound('Not found id');
    }

    $this->model->delete($id);
    return $this->respondDeleted(null);
  }

  public function login()
  {
    $email = $this->request->getVar('email');
    $password = $this->request->getVar('password');

    $data = $this->model->where('email', $email)->first();

    if (!$data) return $this->failNotFound("Invalid email or password");

    $isCorrect = password_verify($password, $data['password']);
    if (!$isCorrect) return $this->failNotFound("Invalid email or password");

    return $this->respond($data);
  }
}
