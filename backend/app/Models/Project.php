<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolioImages()
    {
        return $this->hasMany(PortfolioImage::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function links()
    {
        return $this->hasMany(ProjectLink::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
