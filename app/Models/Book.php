<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'type',
    ];

    protected $casts = [
        'type' => BookTypeEnum::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
