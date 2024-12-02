<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    /**
     * Define the relationship with the Book model.
     * A review belongs to a book.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Define the relationship with the User model.
     * A review belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
}
