<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; //add this line

use App\Models\Book;

class Author extends Model implements AuthenticateContract
{
    use HasFactory, Notifiable, Authenticatable, HasApiTokens; //add this HasApiTokes

    public $timestamps = false;

    protected $fillable = [
        "name",
        "email",
        "password",
        "phone_no"
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
