<?php

// Profile Model
namespace App;

use Illuminate\Database\Eloquent\Model;

class login_details extends Model {
    
  protected $fillable = [
    'user_id', 'login_time', 'logout_time', 'login_count'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [
      'user_id',
  ];
}