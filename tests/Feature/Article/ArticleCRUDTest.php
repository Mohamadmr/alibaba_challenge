<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_screen_can_be_rendered(): void
    {
        $user = User::factory()->hasArticles(5)->create();

        $response = $this->actingAs($user)->get(route('articles.index'));

        $response->assertStatus(200);
        $response->assertSee($user->articles->first()->title);
        $response->assertSee($user->articles->last()->content);
    }

    public function test_edit_screen_can_be_rendered(): void
    {
        $user = User::factory()->hasArticles()->create();

        $response = $this->actingAs($user)->get(route('articles.edit', $user->articles->first()->id));

        $response->assertStatus(200);
        $response->assertSee($user->articles->first()->title);
        $response->assertSee($user->articles->first()->content);
    }

    public function test_show_screen_can_be_rendered(): void
    {
        $user = User::factory()->hasArticles()->create();

        $response = $this->actingAs($user)->get(route('articles.show', $user->articles->first()->id));

        $response->assertStatus(200);

        $response->assertSee($user->articles->first()->title);
        $response->assertSee($user->articles->first()->content);
        $response->assertSee(route('articles.edit', $user->articles->first()->id));
    }

    public function test_create_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('articles.create'));

        $response->assertStatus(200);
    }

    public function test_if_user_not_login_redirect_to_login_instead_read_pages()
    {
        $articleId = User::factory()->hasArticles()->create()->refresh()->articles->first()->id;

        $this->get(route('articles.index'))->assertRedirectToRoute('login');
        $this->get(route('articles.create'))->assertRedirectToRoute('login');
        $this->get(route('articles.edit', $articleId))->assertRedirectToRoute('login');
        $this->get(route('articles.show', $articleId))->assertRedirectToRoute('login');
    }

    public function test_store_an_article()
    {
        $user = User::factory()->create();

        $article = Article::factory()->make()->toArray();
        $article['publication_date'] = now()->toDateString();

        $response = $this->actingAs($user)->post(route('articles.store'), $article);

        $response->assertRedirectToRoute('articles.index');

        $this->assertDatabaseHas('articles', $article);
    }

    public function test_update_an_article()
    {
        $user = User::factory()->hasArticles()->create();

        $article = Article::factory()->make()->toArray();
        $article['publication_date'] = now()->toDateString();

        $response = $this->actingAs($user)->put(route('articles.update', $user->articles->first()->id), $article);

        $response->assertRedirectToRoute('articles.index');

        $this->assertDatabaseHas('articles', $article);
    }

    public function test_delete_an_article()
    {
        $user = User::factory()->hasArticles()->create();

        $article = Article::factory()->make()->toArray();
        $article['publication_date'] = now()->toDateString();

        $response = $this->actingAs($user)->post(route('articles.destroy', $user->articles->first()->id), $article);

        $response->assertMethodNotAllowed();
    }
}
