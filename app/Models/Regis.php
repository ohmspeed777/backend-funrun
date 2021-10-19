<?php

namespace App\Models;

use CodeIgniter\Model;

class Regis extends Model
{
  protected $table = 'regis';
  protected $primaryKey = 'regis_id';
  protected $allowedFields = ['regis_id','member_id', 'category_id'];
}
