# Thryvz_test
## Stage 01
### Task 01 and 02

# API Documentation

## Introduction

This API provides endpoints for process “New Order” with an authentication.

# Run Migration and Seeder
```php artisan Migrate ```
``` php artisan db:seed --class=ProductTableData ```


## Endpoints

### 1. /api/register

- **Method:** POST
- **Description:** Create New User.
- **Parameters:**
  - `name` (required)
  - `email` (required)
  - `password` (required)
  - `password_confirmation` (required)
- **Headers:**
  - `Content-Type` - application/json
- **Response Example:**
  ```json
    {
    "user": {
        "name": "new user 02",
        "email": "nnnew@gmail.com",
        "updated_at": "2024-06-26T05:47:25.000000Z",
        "created_at": "2024-06-26T05:47:25.000000Z",
        "id": 3
    },
    "token": "8|meqc4r48CaAR6dzZve5HC6Muczs3rhkuNn7BXmwC"
  }
 `
### 2. /api/login

- **Method:** POST
- **Description:** Login user tocreate orders.
- **Parameters:**
  - `email` (required)
  - `password` (required)
- **Headers:**
  - `Content-Type` - application/json
- **Response Example:**
  ```json
  {"token": "6|sRtMpoWca7w64cINYNub1K9bf3TCeXjhYPRnP99n"}

`
### 3. /api/get_products

- **Method:** GET
- **Description:** Get Product list.
- **Headers:**
  - `Content-Type` - application/json
- **Response Example:**
  ```json
  [
    {
        "id": 1,
        "product_id": "GZWFPM",
        "product_name": "Senger, Hill and Swift",
        "product_value": "41.00",
        "status": "0",
        "created_at": "2024-06-26T00:24:19.000000Z",
        "updated_at": null,
        "deleted_at": null
    }
  ] `
`
### 4. /api/new_order

- **Method:** POST
- **Description:** Place a new order and send response to 3rd party API endpoint.
- **Parameters:**
  - `customer_id` (required)
  - `product_id` (required)
  - `order_value` (required)
- **Headers:**
  - `Authorization` - Bearer Token [your_token]
  - `Content-Type` - application/json
- **Response Example:**
  ```json
  {
    "message": "Order Created successfully",
    "data": {
        "customer_id": "1",
        "product_id": "WXXPXK",
        "order_value": "78",
        "order_id": "77PYHBESA62K",
        "process_id": 1,
        "updated_at": "2024-06-26T05:32:20.000000Z",
        "created_at": "2024-06-26T05:32:20.000000Z",
        "id": 5
    }
} `

- ** 3rd Party API Example:**
  ```json
  {
    "Order_ID":"77PYHBESA62K",
    "Customer_Name":"new user",
    "Order_Value":"55.50",
    "Order_Date":"2024-06-26 10.35.24",
    "Order_Status":"Proccessing",
    "Process_ID":"10"
  } `
`

## Stage 02
### Task 03 
In Laravel involves using Laravel's built-in features for managing jobs and queues. Laravel provides a robust queue system powered by queues, workers, and job dispatching mechanisms that can efficiently handle high-demand API requests.

### Task 04
This task can be accessed via 127.0.0.1

  
