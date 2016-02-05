RULES
-----
We are using RestfulAPI for creating APIs, please follow these rules

1. Use GET to get data
2. Use POST to create new data
3. Use PUT to update existing data
4. Use DELETE to delete existing data
5. System MUST verify access token before
6. Create endpoint name properly
  example: if you want to get all emails in a special property, please create the API
  ```
  GET /properties/<propertyId>/emails
  ```
  If you want to update one email in a special property, please create the API
  ```
  UPDATE /properties/<propertyId>/emails/<emailId>
  ```

Here are some helpful URLs
[http://www.yiiframework.com/doc-2.0/guide-rest.html](http://www.yiiframework.com/doc-2.0/guide-rest.html)

TESTS
-----
Every API needs many unit tests