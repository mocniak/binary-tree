# binary-tree

configure .env for database connection on line 27
`DATABASE_URL=mysql://root:dupa.8@localhost:3306/tree`
```$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
$ php bin/console server:start```
