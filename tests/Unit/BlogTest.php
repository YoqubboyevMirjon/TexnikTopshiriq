<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function blogs_list_see(): void
    {
        $id = 1 + Blog::latest()->take(1)->get();
        Blog::factory()->create([
            'id' => 1 + Blog::latest()->take(1)->get(),
            'user_id' => 1,
            'title' => 'Hello World',
            'content' => 'Blog\'s content',
        ]);
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('All Blog');
        $response->assertSee($id);
        $response->assertSee('Hello World');
        $response->assertSee('Blog\'s content');
        $response->assertSee('Read more');
        $response->assertSee('days ago');
        $response->assertPaginate();
    }

    public function blogs_dashboard_see(): void
    {
        $user = User::factory()->create();

        $id = 1 + Blog::latest()->take(1)->get();
        Blog::factory()->create([
            'id' => $id,
            'user_id' => 1,
            'title' => 'Hello World',
            'content' => 'Blog\'s content',
        ]);

        $response = $this->actingAs()->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Your Blog');
        $response->assertSee($id);
        $response->assertSee('Hello World');
        $response->assertSee('Edit');
        $response->assertSee('Delete');
        $response->assertSee('Read more');
        $response->assertSee('Blog\'s content');
        $response->assertPaginate();
    }

    public function blog_create_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs()->get('/blogs/create');

        $response->assertOk();
        $response->assertSee('Create New Blog');
        $response->assertSee('You can create only 3 blog in a day!');
        $response->assertSee('Create');
    }

    public function test_blog_show_one_page()
    {
        $user = User::factory()->create();

        $id = 1 + Blog::latest()->take(1)->get();
        Blog::factory()->create([
            'id' => $id,
            'user_id' => 1,
            'title' => 'Hello World',
            'content' => 'Blog\'s content',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/blogs' . $id);

        $response->assertOk();
        $response->assertSee($id . ' - Blog');
        $response->assertSee('Hello World');
        $response->assertSee('Blog\'s content');
    }
}
