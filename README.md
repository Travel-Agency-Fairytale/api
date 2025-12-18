[![Code Style](https://img.shields.io/badge/code%20style-php--cs--fixer-brightgreen)](
https://github.com/FriendsOfPHP/PHP-CS-Fixer
)
[![CI](https://github.com/Travel-Agency-Fairytale/api/actions/workflows/ci.yml/badge.svg)](
https://github.com/Travel-Agency-Fairytale/api/actions/workflows/ci.yml
)
# Travel-Agency-Fairytale API

This repository contains the core API backend for Travel-Agency-Fairytale. The API is designed to communicate with external services and aggregate travel-related data for downstream applications.

## Language Composition

- PHP (63%)
- JavaScript (31%)
- Blade (6%)

## Purpose

This API serves to:
- Integrate with various external travel services
- Aggregate and normalize data from external sources
- Provide unified endpoints for consuming aggregated travel data

## Features

- Connects to multiple external travel data providers
- Collects and merges data such as destinations, accommodations, pricing, and availability
- Exposes RESTful endpoints for client consumption

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Travel-Agency-Fairytale/api.git
   
2. **Install dependencies:**
- Requires PHP and Composer
- For JavaScript dependencies, use npm or yarn
  ```bash 
    sail composer install
    sail npm install
  
3. **Configure environment variables:**
- Copy .env.example to .env and set the relevant variables for external service keys, database, etc.
  ```bash
  cp .env.example .env
  
4. **Run migrations (if needed):**
- ```bash
    sail artisan migrate
  
5. **Start the development server:**
-  ```bash
    sail up -d

## Contributing
Pull requests and issues are welcome! Please review contributing guidelines before proposing changes.
