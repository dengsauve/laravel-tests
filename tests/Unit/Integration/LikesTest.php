<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\User;

class LikesTest extends Tests\TestCase
{
    use DatabaseTransactions;

    protected $post;

    public function setUp()
    {
        parent::setUp();

        // Given I gave a post every time
        $this->post = createPost();

        // And am acting as an authenticated user
        $this->signIn();
    }

    public function testAUserCanLikeAPost()
    {
        //when a user likes a post
        $this->post->like();

        //there should be evidence in the database, and the post should be liked
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    public function testAUserCanUnlikeAPost()
    {
        //when a user unlikes a post
        $this->post->like();
        $this->post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    public function testUserTogglePostLikeStatus()
    {
        //when a user toggles a like on a post
        $this->post->toggle();

        //there should be evidence in the database, and the post should be liked
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();

        //there should be evidence in the database, and the post should not be liked
        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    public function testAPostKnowsHowManyLikesItHas()
    {
        //when a user toggles a like on a post
        $this->post->like();

        $this->assertEquals(1, $this->post->likesCount);
    }
}