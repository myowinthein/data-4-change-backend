### Tool Requirements

| Title | Version |
| -- | -- |
| Apache | 2.4.41 |
| PHP | 7.3.11 |
| MySQL | 8.0.19 |
| Composer | 1.9.0 |

___

### Installation

__.env__

- Copy from [.env.example](#.env.example)

__Virtual Host__

- data4change.local
- data4change.local/api

__Terminal__

```bash
#clone the repository
git clone url

#install packages
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

- Root
	- admin@data4change.com, password
