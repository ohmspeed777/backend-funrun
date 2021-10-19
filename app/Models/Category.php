<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
  protected $table = 'category';
  protected $primaryKey = 'category_id';
  protected $allowedFields = ['category_id','category_name', 'length', 'price'];
}
