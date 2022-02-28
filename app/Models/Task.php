<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'id',
        'due_date'
    ];

    protected  $hidden = [
        'pivot'
    ];

    public $incrementing = false;


    public function users()
    {
        return $this->belongsToMany(User::Class, 'user_task');
    }
}
