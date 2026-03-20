# Discussion App - Database Setup Guide

## Running Migrations

Run all migrations to create the tables:

```bash
cd d:\Visual Projects\laravelAPI-app
php artisan migrate
```

This will create the following tables:
- `users` (already exists)
- `protocols` - Healthcare protocols/guidelines
- `threads` - Discussion threads
- `comments` - Comments on threads
- `reviews` - Reviews of protocols
- `votes` - Votes on threads and comments

## Running Seeders

Populate the database with mock data:

```bash
php artisan db:seed
```

This will run all seeders in order:
1. **UserSeeder** - Creates test users (already exists)
2. **ProtocolSeeder** - Creates 12 protocols
3. **ThreadSeeder** - Creates 10 discussion threads
4. **CommentSeeder** - Creates 3-8 comments per thread
5. **ReviewSeeder** - Creates 2-4 reviews per protocol
6. **VoteSeeder** - Creates upvotes/downvotes on comments and threads

## Specific Seeders

You can run individual seeders:

```bash
php artisan db:seed --class=ProtocolSeeder
php artisan db:seed --class=ThreadSeeder
php artisan db:seed --class=CommentSeeder
php artisan db:seed --class=ReviewSeeder
php artisan db:seed --class=VoteSeeder
```

## Resetting Database

To reset and reseed (drop all tables and recreate):

```bash
php artisan migrate:refresh
php artisan db:seed
```

## Database Tables Overview

### Protocols Table (12 records)
```
id, user_id, title, description, status, views, created_at, updated_at
```

### Threads Table (10 records)
```
id, protocol_id, user_id, title, content, views, replies, created_at, updated_at
```

### Comments Table (~40-80 records)
```
id, thread_id, user_id, content, likes, created_at, updated_at
```

### Reviews Table (~24-48 records)
```
id, protocol_id, user_id, content, rating, created_at, updated_at
```

### Votes Table (~100-200 records)
```
id, user_id, voteable_type, voteable_id, type, created_at, updated_at
```

## API Endpoints to Test

After seeding, test these endpoints:

```bash
# Get all protocols
GET http://localhost:8000/api/protocols

# Get single protocol with threads and reviews
GET http://localhost:8000/api/protocols/1

# Get protocols by status
GET http://localhost:8000/api/protocols/status/active

# Get all threads
GET http://localhost:8000/api/threads

# Get single thread with comments
GET http://localhost:8000/api/threads/1

# Get threads for a protocol
GET http://localhost:8000/api/protocols/1/threads
```

## Troubleshooting

If migrations fail:
1. Check database connection in `.env`
2. Ensure database exists: `CREATE DATABASE laravelapi_app;`
3. Run: `php artisan migrate:refresh`

If seeders fail:
1. Run migrations first: `php artisan migrate`
2. Check that all model classes exist
3. Run: `php artisan db:seed`
