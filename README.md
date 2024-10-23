# Laravel + Next.js Image Generator

This is a simple image generator application built with Laravel as the backend API and Next.js as the frontend.

## Features

- User authentication with Laravel Sanctum
- Image upload and generation with Intervention Image
- Image preview with Next.js Image component
- Responsive design with Tailwind CSS

## Installation
1. Clone the repository
## Run with Laravel Docker
1. Go to the `backend` directory
2. Run `docker-compose up -d` to start the Docker containers
3. Run `docker-compose exec app composer install` to install dependencies
3. Run `docker-compose exec app php artisan migrate --seed` to create the database tables and seed the database
4. Set the following environment variables:
    - `AWS_ACCESS_KEY_ID`
    - `AWS_SECRET_ACCESS_KEY`
    - `AWS_DEFAULT_REGION`
    - `AWS_BUCKET`
    - `AWS_USE_PATH_STYLE_ENDPOINT`
- To test the application, run `docker-compose exec app php artisan test`


## Run with Next.js
1. Go to the `frontend` directory
2. Run `docker build -t nextjs-app .` to build the docker containers
3. Run `docker run -p 3000:3000 nextjs-app` to start the Next.js server 

## Usage

1. Go to `http://localhost:3000` in your browser
2. Click on the "Upload Image" button to upload an image
3. Click on the "Generate Image" button to generate the image
4. The generated image will be displayed in the browser

## API Endpoints

### POST /api/login

**Description:**  
Authenticate a user and return a token.

**Request Parameters:**  
- `email` (string): User's email address.
- `password` (string): User's password.

### POST /api/register

**Description:**  
Register a new user account.

**Request Parameters:**  
- `name` (string): User's full name.
- `email` (string): User's email address.
- `password` (string): User's password.

### GET /api/image

**Description:**  
Retrieve a list of all images.


### POST /api/image

**Description:**  
Upload a new image and generate a processed version.

**Request Parameters:**  
- `image` (file): Image file to be uploaded.

### GET /api/image/{id}

**Description:**  
Retrieve details of a specific image by ID.

**Request Parameters:**  
- `id` (integer): Unique identifier of the image.

## License

The Laravel + Next.js Image Generator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
