<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\User;

class LikesTest extends Tests\TestCase
{
    use DatabaseTransactions;

    public function testAUserCanLikeAPost()
    {
        //given I have a post and a user
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        //and the user is logged in
        $this->actingAs($user); //$this->be($user) //Also works!

        //when a user likes a post
        $post->like();

        //there should be evidence in the database, and the post should be liked
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertTrue($post->isLiked());
    }

    public function testAUserCanUnlikeAPost()
    {
        //given I have a post and a user
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        //and the user is logged in
        $this->actingAs($user); //$this->be($user) //Also works!

        //when a user unlikes a post
        $post->like();
        $post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertFalse($post->isLiked());
    }

    public function testUserTogglePostLikeStatus()
    {
        //given I have a post and a user
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        //and the user is logged in
        $this->actingAs($user); //$this->be($user) //Also works!

        //when a user toggles a like on a post
        $post->toggle();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertTrue($post->isLiked());

        $post->toggle();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertFalse($post->isLiked());
    }

    public function testAPostKnowsHowManyLikesItHas()
    {
        //given I have a post and a user
        $post = factory(App\Post::class)->create();
        $user = factory(App\User::class)->create();

        //and the user is logged in
        $this->actingAs($user); //$this->be($user) //Also works!

        //when a user toggles a like on a post
        $post->like();

        $this->assertEquals(1, $post->likesCount);
    }
}