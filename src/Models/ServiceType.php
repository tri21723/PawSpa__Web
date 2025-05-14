<?php

namespace App\Models;

use App\Core\Model;

class ServiceType extends Model
{
  protected static $table = 'ServiceType';
  protected static $primaryKey = ['servicetype_id'];

  public $servicetype_id;
  public $name;
  public $description;

  public static function findByName(string $name)
  {
    return self::findOneBy('name', $name);
  }
}