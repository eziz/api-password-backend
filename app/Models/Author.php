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

    const INACTIVE = 0;
    const PENDING = 1;
    const ACTIVE = 2;

    const DEFAULT_ADMIN_EMAIL = 'eziz@admin.com';

    const WHOLESALER_TYPE = 'wholesaler';
    const RETAILER_TYPE = 'retailer';

    const TYPE_USER = 'U';
    const TYPE_ADMIN = 'A';

    /**
     * Roles
     */
    const ADMINS = [
        'admin' => [
            'products',
        ],
    ];

    const CLIENTS = [
        'wholesaler' => [],
        'customer' => [],
    ];

    const ROLE_TYPES = [
        'admin' => [],
        'wholesaler' => [
            'manufacturer',
            'importer',
        ],
        'customer' => [],
    ];

    //public $timestamps = false;

    protected $fillable = [
        "name",
        "email",
        'status',
        "password",
        "phone_no"
    ];

    protected $casts = [
        'activated_date' => 'date',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
