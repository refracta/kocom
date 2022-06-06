<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
        $post = Post::whereId(20);
        print "Hello World";

        print $post->getSimpleCreatedAt();
    }


}
