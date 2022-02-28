# Laravel code challenge
You have been tasked with creating a task board app. The priority is to keep track of all users and tasks and easily manage them.

The goal of this challenge is to evaluate your approach and execution rather than the end result. We want to see how you structure your code, make use of Laravel's built in features and general best practices. You can keep the UI as minimal as you want as we'll only focus on the backend.

# Requirements
Build a simple dashboard that will allow you do the following:

- [v] List all users and their respective tasks
- [v] CRUD a user
- [v] CRUD a task
- [v] Assign a task to a user
- [v] Remove a task from a user
- [v] Download a list of all users and tasks as a JSON
- [v] Create a seeder for users and tasks


Notes:
- 1 user can have multiple tasks and the same task can be assigned to more than 1 user
- You can use Laravel's own migration for the users table, no need to create a new one
- There's a JSON file in the repo with a few example users and tasks which you can use to build your seeder file (so you don't have to come up with names, etc); when you build the download feature, the file structure should look the same as this one.

----

# How to Install and Run the Project

This project is created by Laravel Sail.

After clone and enter this project,
you could run this project on the docker environment.

1. Run docker app
2. Use Sail command to serve this project

----

Install Laravel Sail:

```
composer require laravel/sail --dev
```

```
./vendor/bin/sail up
```

If you already have the Sail environment, just:

```
./vendor/bin/sail up
```

or

```
sail up
```
