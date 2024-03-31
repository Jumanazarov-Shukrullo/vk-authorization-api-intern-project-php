# Laravel Auth Functions Documentation
# The code for the documentation can be found [here](https://github.com/Jumanazarov-Shukrullo/vk-authorization-api-intern-project-php/blob/main/app/Http/Controllers/AuthController.php)
This documentation outlines three functions within a Laravel application related to user authentication: `authorize`, `register`, and `feed`.

## Authorize Function

The `authorize` function is responsible for authenticating users based on their email and password credentials. It returns a JSON response indicating the success or failure of the authentication attempt.

### Request

- **Method:** POST
- **Endpoint:** /api/authorize
- **Request Body:**
```json
{
    "email": "user@example.com",
    "password": "secret"
}
```

### Response

- **Success (200 OK):**
```json
{
    "status": "success",
    "user": {
        "id": 1,
        "email": "user@example.com",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "updated_at": "YYYY-MM-DD HH:MM:SS"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ5NT...",
    "token_type": "bearer"
}
```

- **Error (401 Unauthorized):**
```json
{
    "status": "error",
    "message": "Unauthorized"
}
```

## Register Function

The `register` function is responsible for creating new user accounts. It validates the input data, creates the user record in the database, and returns a JSON response indicating the success or failure of the registration attempt.

### Request

- **Method:** POST
- **Endpoint:** /api/register
- **Request Body:**
```json
{
    "email": "newuser@example.com",
    "password": "secretpassword"
}
```

### Response

- **Success (200 OK):**
```json
{
    "status": "success",
    "message": "User created successfully",
    "user": {
        "id": 2,
        "email": "newuser@example.com",
        "created_at": "YYYY-MM-DD HH:MM:SS",
        "updated_at": "YYYY-MM-DD HH:MM:SS"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ5NT...",
    "token_type": "bearer"
}
```

- **Error (400 Bad Request):**
```json
{
    "status": "error",
    "message": "Validation Error: The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```

## Feed Function

The `feed` function is a placeholder function that requires authentication via an access token. It returns a `200 OK` response if the token is valid or a `401 Unauthorized` response if the token is invalid or not provided.

### Request

- **Method:** GET
- **Endpoint:** /api/feed
- **Authorization Header:** Bearer <access_token>

### Response

- **Success (200 OK):**
```json
{
    "status": "success",
    "message": "Authorized"
}
```

- **Error (401 Unauthorized):**
```json
{
    "status": "error",
    "message": "Unauthorized"
}
```
