### Tool Requirements

| Title | Version |
| -- | -- |
| Apache | 2.4.41 |
| PHP | 7.3.11 |
| MySQL | 8.0.19 |
| Composer | 1.9.0 |

___

### Installation

##### .env
`Copy from .env.example`

##### Virtual Host
- data4change.local
- data4change.local/api

##### Terminal

```shell
#clone the repository
git clone git@gitlab.com:data-4-change/backend.git

#install composer packages
composer install

#migrate & seed database
php artisan migrate:refresh --seed

#add jwt key
php artisan jwt:secret

#link storage to public
php artisan storage:link
```
___

### Login

| Type | Email | Password |
| -- | -- | -- |
| Root | admin@data4change.com | password |