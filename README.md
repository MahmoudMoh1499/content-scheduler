# Content Scheduler

## Overview
The Content Scheduler is a web application designed to help users manage and schedule their posts across various platforms. It allows users to create, edit, and schedule posts, ensuring that content is published at the right time on the right platforms.

## Features
- User authentication and management
- Create and manage posts with titles, content, and images
- Schedule posts for future publication
- Integration with multiple platforms for posting
- Track the status and responses of posts on different platforms

## Setup Instructions
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd content-scheduler
   ```
3. Install the required dependencies:
   ```
   composer install
   ```
4. Set up your environment variables by copying the `.env.example` file to `.env`:
   ```
   cp .env.example .env
   ```
5. Generate the application key:
   ```
   php artisan key:generate
   ```
6. Run the database migrations:
   ```
   php artisan migrate
   ```

## Usage Guidelines
- Start the local development server:
  ```
  php artisan serve
  ```
- Access the application in your web browser at `http://localhost:8000`.
- Register a new account or log in with an existing account to start creating and scheduling posts.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.
