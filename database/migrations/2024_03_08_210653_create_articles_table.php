<?php

use App\Models\Enums\ArticlePublishTypeEnum;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('content')->fulltext();
            $table->foreignIdFor(User::class, 'author_id');
            $table->date('publication_date');
            $table->unsignedTinyInteger('publication_status')->default(ArticlePublishTypeEnum::draft->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
