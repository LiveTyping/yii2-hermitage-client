Yii2 Hermitage Client
====================

Yii2 Adapter for [Hermitage Client](https://github.com/LiveTyping/hermitage-php-client).

# Installation

1. Run the [Composer](http://getcomposer.org/download/) command to install the latest version:

    ```bash
    composer require livetyping/yii2-hermitage-client ~0.1
    ```

2. Add the component to `config/main.php`:

    ```php
    'components' => [
        // ...
        'hermitage' => [
            'class' => 'livetyping\hermitage\client\yii2\Component',
            'secret' => '<secret value>',
            'baseUri' => 'http://hermitage',
            // 'algorithm' => 'sha256',
        ],
        // ...
    ],
    ```

# Usage

```php
<?php

/** @var \livetyping\hermitage\client\contracts\Client $client */
$client = Yii::$app->get('hermitage');

/** @var \Psr\Http\Message\ResponseInterface $response */
$response = $client->upload(file_get_contents('path/to/local/image'));
$filename = json_decode((string)$response->getBody());
$filename = $filename['filename'];

$response = $client->get($filename, '<version name>');

$response = $client->delete($filename);

/** @var \Psr\Http\Message\UriInterface $uri */
$uri = $client->uriFor($filename, '<version name>');
```

# License

Yii2 Hermitage Client is licensed under the MIT License.

See the [LICENSE](LICENSE) file for more information.
