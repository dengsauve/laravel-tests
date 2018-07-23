# Laravel Testing

Working through the PHPUNIT-Testing in Laracasts

## Database Tips

Include `use Illuminate\Foundation\Testing\DatabaseTransactions` at the head of any database testing, 
and then include `use DatabaseTransactions` in the body of the test to "fake" data.

## Terms
- **Regression Test** - A test that recreates a reported bug, and continues to test for that case after
a fix has been created.
