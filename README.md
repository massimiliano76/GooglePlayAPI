Google Play API
==========

## Installation

Add the following line to `composer.json` :

```json
{
    "require": {
        "rashidlaasri/googleplayapi": "1.0"
    }
}
```

Run `composer update`.

### Setup

Add ServiceProvider to the providers array in `app/config/app.php`.

```
'RachidLaasri\GooglePlayAPI\GooglePlayServiceProvider',
```

Add Facade : 

```
'GooglePlay'  => 'RachidLaasri\GooglePlayAPI\Facades\GooglePlay',
```
### Usage
```php

$app = Googleplay::app('APP_URL');

echo $app->URL;
echo $app->title;
echo $app->published_at;
echo $app->price;
echo $app->required_version;
echo $app->icon;
echo $app->last_updated;
echo $app->installation_count;
echo $app->author_name me;
echo $app->author_store_URL;
echo $app->author_website;
echo $app->author_email;
echo $app->HTML_description;
echo $app->plain_text_description;
echo $app->HTML_updates;
echo $app->plain_text_updates;
foreach($app->screenshots as $screenshot)
{
    echo $screenshot;
}

// Override default configuration :

Googleplay::config([
    'saveImages' => false,  // Save images to local.
    'imagesDir' => './images/', // Path to save images to.
    '$tempDir' => './temp/', // Cache folder.
    'cacheTime' => 120 // Cache time per seconds.
]);

// You can chain methods :

Googleplay::config(['cacheTime' => 600])->app("APP_URL")->title;

```

## Contribute

https://github.com/rachidlaasri/googleplayapi/pulls
