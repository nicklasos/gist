# Unit tests

```php
// Mock guzzle client

$client = mock(Client::class);
$client->shouldReceive('post')->andReturn(mock_guzzle_response(fixture('response.json')));
```
