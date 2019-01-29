<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\Category;
use App\User;
class Ticket extends Model
{
    protected $fillable =['user_id', 'ticket_id', 'category_id', 'title', 'priority','status','message'];


    //one-to-many relation between ticket and category
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //one-to-many relationship with comment
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    //one to many relationship with the user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
