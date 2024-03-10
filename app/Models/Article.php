<?php

namespace App\Models;

use App\Models\Enums\ArticlePublishTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'content', 'publication_date', 'publication_status'];

    protected $casts = [
        'publication_date' => 'date',
        'publication_status' => ArticlePublishTypeEnum::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
