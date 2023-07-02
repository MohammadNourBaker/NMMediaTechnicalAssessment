<?php namespace App\Models;

use CodeIgniter\Model;

class ConnectionModel extends Model{

  protected $table = 'connections';
  protected $allowedFields = ['user_id', 'full_name'];
}
