<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function booted()
    {
        static::creating(function ($genre) {
            $genre->slug = $genre->slug ?? \Illuminate\Support\Str::slug($genre->name);
        });
    }
}