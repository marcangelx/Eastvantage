# PHP test

## 1. Installation

- create an empty database named "phptest" on your MySQL server
- import the dbdump.sql in the "phptest" database
- put your MySQL server credentials in the constructor of DB class
- you can test the demo script in your shell: "php index.php"

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

- easier to work with
- more maintainable

## Changes that I have made

- I started by refactoring and implementing constructor injection on the Comment and News classes to adhere to the SOLID principle.
  ![Alt text](constructor-injection.jpg?raw=true "Title")

- Install a PSR-4 library using Composer to manage and organize the application's files.
  ![Alt text](psr4-compliance.jpg?raw=true "Title")

- Decouple the NewsManager and CommentManger class. Use the dependency injection pattern to make the classes testable and maintainable.
  ![Alt text](dependency-injection.jpg?raw=true "Title")

- I started working on optimizing the queries(see the NewsManager->listNews method) and have noticed that there are unnecessary queries caused by the nested loop in index.php. I have two options: make a query left join to get both tables in just one query, or make a function that retrieves comments by ids. It is important to note that in the long run (when querying big data), We must always specify the id or key to ensure we will only get the data we need and not all the data inside our database(it considered as bad practice). With this approach, we will lessen the load of the application.
  ![Alt text](optimize-query.jpg?raw=true "Title")

- Pagination is a common pattern used in database queries to limit the amount of data that is returned in a single request. It's important to note that pagination alone is not a security measure, it should be used in conjunction with other security measures such as input validation, and prepared statements.
  ![Alt text](pagination-pattern.jpg?raw=true "Title")

## codes vulnerable to Dependency Injection, CSRF, XSS, etc.,

- Use type-hinting tecnique This can help to ensure that the correct dependencies are injected and that the dependencies are of the correct type.

- Use htmlspecialchars() method to convert special characters to to their corresponding HTML entities, so they can't be executed as code.

- Use quote method to escape input of users to protect queries from SQL injection.
  ![Alt text](data-protection.jpg?raw=true "Title")
