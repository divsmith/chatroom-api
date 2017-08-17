# Parker Smith CS3620 Final Project

## Installation

Clone the project into a directory, then run

    composer install
    
Rename `.env.example` to `.env` and fill in the required environment variables.

Change all 4 `volumes:` paths in `docker-composer.yml` to match your installation directory.

## Running
Run the application by typing `docker-compose up -d` in the project directory. The project will then be viewable on
the local machine, usually at `172.18.0.1`

## Tests
Run unit tests by typing `vendor/bin/codecept run unit` in the project directory. 

Code coverage results can be viewed by running `vendor/bin/codecept run unit --coverage`

Integration tests can be run by importing `postman_integration_tests.json` into Postman. Add a `url`
environment variable that corresponds to the local base url that the chatroom server is running on, then
run the `Chatroom Tests` collection.

## Endpoints
### Create User Profile
Create a new user profile

`POST /user/`

##### Parameters 
- **email** - Email address for the user (cannot be changed)
- **alias** - Alias for the user

##### Response
- **location**

##### Errors
- **406** - Invalid email address

##### Example Request
`POST /user`
```javascript
{
    email: "john@smith.com",
    alias: "jsmith"
}
```

##### Example Response
`201 Created`
```javascript
{
    "users/john@johnsmith.com"
}
```

### Update User Profile
Update a  user profile

`PUT /user/{email}`

##### Parameters 
- **alias** - Alias for the user
- **chatroomID** - (Optional) UUID of the chatroom to join.

##### Response
- **None**

##### Errors
- **404** - Invalid user

##### Example Request
`PUT /user/john@smith.com`
```javascript
{
    alias: "jsmith",
    chatroomID: "asdf-1234"
}
```

##### Example Response
`206 Success`

### Create Chatroom
Create a new chatroom

`POST /chatroom/`

##### Parameters 
- **name** - Name for the chatroom

##### Response
- **location**

##### Errors
- **500** - Server error

##### Example Request
`POST /chatroom`
```javascript
{
    name: "Jim's Chatroom"
}
```

##### Example Response
`201 Created`
```javascript
{
    "chatroom/asdf-1234"
}
```

### Update Chatroom
Update a chatroom

`PUT /chatroom/{uuid}`

##### Parameters 
- **name** - New chatroom name

##### Response
- **None**

##### Errors
- **404** - Invalid chatroom

##### Example Request
`PUT /chatroom/asdf-1234`
```javascript
{
    name: "John' Chatroom"
}
```
##### Example Response
`206 Success`

### Post Message
Post a message to the currently joined chatroom

`POST /user/{email}/chatroom/messages`

##### Parameters 
- **message** - Message to post

##### Response
- **location**

##### Errors
- **404** - Invalid user
- **406** - Not joined to a chatroom

##### Example Request
`POST /user/john@smith.com/chatroom/messages`
```javascript
{
    message: "Hello everyone! This is my message"
}
```

##### Example Response
`201 Created`
```javascript
{
    "message/jkl-5678"
}
```

### View Messages
View messages from currently joined chatroom

`GET /user/{email}/chatroom/messages`

##### Parameters 
- **Start Date** - (Optional)
- **End Date** - (Optional)

##### Response
- **json array**

##### Errors
- **404** - Invalid user
- **406** - Not joined to a chatroom

##### Example Request
`GET /user/{email}/chatroom/messages?start=2017-08-14&end=2017-08-16`

##### Example Response
`200 OK`
```javascript
[
    {
        "email": "john@smith.com",
        "message": "Hello everyone! This is my message",
        "chatroomID": "asdf-1234",
        "dateUpdated": "2017-08-15 00:00:00",
        "dateCreated": "2017-08-15 00:00:00",
        "uuid": "jkl-1234"
    },
    {
        "email": ".....",
        "message": "....",
        .....
    }
]
```

