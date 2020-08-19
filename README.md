## Simple Users API
Introduces simple REST API for creating one user and fetching list of users. As a data source for demonstration purposes 
implemented XML in file and Database in SQLite.  
Implemented endpoints:

* GET /api/v1/users/{page}
* POST /api/v1/users

Response is in JSON format.  
Example:

```json
{
    status: 200,
    data: {
        users: [
            {
                login: "test3",
                createdDate: "1901-01-01 00:00:00",
                updatedDate: "1950-02-01 12:00:11",
                role: "1",
                status: "1"
            }
        ],
        currentPage: 2,
        totalPages: 2
      }
}
```

### Installation
Using Symfony 5.1. 
```shell script
composer install
```

### Utilizing
Please refer to documentation page:  
```/api/v1/doc.json```

For creating user please use following example request:

```shell script
curl --location --request POST 'http://127.0.0.1:8000/api/v1/users?source=xml' \
--form 'login=test' \
--form 'password=123' \
--form 'createdDate=1901-01-01 00:00:00' \
--form 'updatedDate=1950-02-01 12:00:11' \
--form 'role=1' \
--form 'status=1'
```

Switching between data sources is possible with optional query parameter `source` = (`xml`,`database`)

### Testing
At the moment implemented some unit tests to test get list of users endpoint:  
```php ./vendor/bin/phpunit```

@[Vladyslav Semerenko](mailto:vladyslav.semerenko@gmail.com)
