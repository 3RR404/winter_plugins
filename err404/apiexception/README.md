# Api

## Description
Implement API standard to CMS

## Usage
- Usage of ApiExceptionMiddleware
  ```php
  Route::group(['prefix' => 'api/v1', 'middleware' => [ApiExceptionMiddleware::class]], function () {
      ...
  });
  
  Example of error response:
  {
    "error": "Order not found",
    "statusCode": 404
  }
  ```
- Usage of ApiResponse trait
  ```php
  class BlogController extends Controller
  {
      use ApiResponse;
        
      ...
  }
  
  Example of success response:
  {
      "data": [],
      "statusCode": 200
  }
  ```