# Files Downloader

## Installation

- clone code & go to the project dir
- `$ composer install`
- `$ touch ./database/database.sqlite`
- `$ php -r "file_exists('.env') || copy('.env.example', '.env');"`
- `$ php artisan key:generate --ansi`
- `$ php artisan migrate`
- `$ php artisan serve`

## API

- [GET] /api/files - list of all files
- [POST] /api/files - create & put file downloading to the queue. 
    * request:
        * url: "https://s.gravatar.com/avatar/9ec4a7300ccf8fda2a5a25af3bf898be?s=200"
- [GET] /api/files/{id} - get file by id

## UI

- [GET] / - create & put file downloading to the queue.
- [GET] /files - list of all files

## CLI

- app:file:download <url> - create & put file downloading to the queue.
- app:file:list - list of all files