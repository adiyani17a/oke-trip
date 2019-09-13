<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment_history_d extends Model
{
    protected $table = 'payment_history_d';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'dt', 'bank', 'nominal', 'account_name','account_number', 'image', 'date', 'created_at', 'updated_at'
    					];

}
