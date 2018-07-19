<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Article;

class ArticleTest extends Tests\TestCase
{
    use DatabaseTransactions;

    // Fetch trending articles
    function testItFetchesTrendingArticles()
    {
        // Given 5 articles, two with larger views than 0 (default)
        factory(Article::class, 3)->create();
        factory(Article::class)->create(['reads' => 10]);
        $mostPopular = factory(Article::class)->create(['reads' => 20]);

        // When selecting trending articles (top 3 by views)
        $articles = Article::trending();

        // Then most popular is at top, and three returned
        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }
}