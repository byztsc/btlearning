<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['teacher_id', 'title', 'slug', 'description', 'color'];

    /** @return BelongsTo<User, $this> */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /** @return BelongsToMany<User, $this> */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /** @return HasMany<Material, $this> */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /** @return HasMany<Announcement, $this> */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    // Adreslerde id yerine slug kullan: /courses/web-development
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
