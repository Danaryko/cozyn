<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardingHouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'user_id',
    'city_id',    
    'category_id',
    'name',
    'slug',
    'address',
    'description',
    'price',
    'thumbnail',
    'room_size',
    'room_facilities',
    'bathroom_facilities',
    'general_facilities', 
    'parking_facilities',
    'rules',
    'status',
    ];

    protected $casts = [
    'room_facilities' => 'array',
    'bathroom_facilities' => 'array',
    'rules' => 'array',
    ];

    public function city()  {
        return $this->belongsTo(City::class);
    }

    public function category()  {
        return $this->belongsTo(Category::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
