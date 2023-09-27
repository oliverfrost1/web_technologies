<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id',
        'due_date',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user that owns the todo.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}