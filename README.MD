# Laravel Testing

Working through the PHPUNIT-Testing in Laracasts

## Database Tips

Include `use Illuminate\Foundation\Testing\DatabaseTransactions` at the head of any database testing, 
and then include `use DatabaseTransactions` in the body of the test to "fake" data.

