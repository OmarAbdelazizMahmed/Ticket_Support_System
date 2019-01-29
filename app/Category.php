<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ticket;
class Category extends Model
{
    protected $fillable = ['name'];

    //ticket realtion 
    public function ticket(){
        return $this->hasMany(Ticket::class);
    }
}
