<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'contact_messages';

    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'subject',
        'message',
        'newsletter',
    ];

    protected $casts = [
        '_id' => \MongoDB\Laravel\Eloquent\Casts\ObjectId::class,
        'newsletter' => 'bool',
    ];
}
