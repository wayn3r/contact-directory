<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = ['name', 'lastname'];


    public function addresses(){
        return $this->hasMany(Address::class, 'contactId', 'id');
    }

    public function phones(){
        return $this->hasMany(Phone::class, 'contactId', 'id');
    }
}
