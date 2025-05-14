<?php

namespace App\Models;

use App\Core\Model;

class Service extends Model
{
  protected static $table = 'Service';
  protected static $primaryKey = ['service_id'];

  public $service_id;
  public $name;
  public $description;
  public $price;
  public $original_price;
  public $uration;
  public $servicetype_id;

  public static function findByName(string $name)
  {
    return self::findOneBy('name', $name);
  }
}