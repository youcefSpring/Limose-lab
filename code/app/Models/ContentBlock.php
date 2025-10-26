<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'key',
        'title_ar',
        'title_fr',
        'title_en',
        'content_ar',
        'content_fr',
        'content_en',
        'type',
        'page',
        'section',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_en ?? $this->title_fr ?? $this->title_ar;
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"content_{$locale}"} ?? $this->content_en ?? $this->content_fr ?? $this->content_ar;
    }

    public static function getByKey($key)
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }

    public static function getByPageSection($page, $section = null)
    {
        $query = static::where('page', $page)->where('is_active', true);

        if ($section) {
            $query->where('section', $section);
        }

        return $query->orderBy('order')->get();
    }
}
