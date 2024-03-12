<?php

namespace Tests\Feature\Article;

use App\Models\Enums\ArticlePublishTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminActionsOnArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_screen_can_be_rendered(): void
    {
        $user = User::factory()->hasArticles(5)->create();

        $user->articles->first()->publish();

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee($user->articles->first()->title);
        $response->assertSee($user->articles->last()->content);
    }

    public function test_admin_trashed_screen_can_be_rendered(): void
    {
        $user = User::factory()->hasArticles(5)->create();

        $user->articles->first()->delete();

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('articles.trashed'));

        $response->assertStatus(200);
        $response->assertSee($user->articles->first()->title);
        $response->assertDontSee($user->articles->last()->content);
    }

    public function test_admin_can_restore_an_article(): void
    {
        $user = User::factory()->hasArticles(5)->create();

        $user->articles->first()->delete();

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('articles.restore', $user->articles->first()->id));

        $response->assertRedirectToRoute('dashboard');

        $this->assertNull($user->articles()->first()->deleted_at);
    }

    public function test_admin_delete_an_article()
    {
        $article = User::factory()->hasArticles()->create()->articles()->first();

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->delete(route('articles.destroy', $article->id));

        $response->assertRedirectToRoute('dashboard');

        $this->assertNotNull($article->fresh()->deleted_at);
    }

    public function test_admin_publish_an_article()
    {
        $article = User::factory()->hasArticles()->create()->articles()->first();

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('article.publish', $article->id));

        $response->assertRedirectToRoute('dashboard');

        $this->assertEquals(ArticlePublishTypeEnum::published, $article->fresh()->publication_status);
    }
}
