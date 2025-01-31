<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Worksheet extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
        "id","user_id","date","project_id","task","description","status","created_at","updated_at"
    ];
    
	public function user() {
		return $this->belongsTo(User::class);
	}

}
