# Laravel code challenge
You have been tasked with creating a task board app. The priority is to keep track of all users and tasks and easily manage them.

The goal of this challenge is to evaluate your approach and execution rather than the end result. We want to see how you structure your code, make use of Laravel's built in features and general best practices. You can keep the UI as minimal as you want as we'll only focus on the backend.

# Requirements
Build a simple dashboard that will allow you do the following:

- [] List all users and their respective tasks
- [] CRUD a user
- [] CRUD a task
- [] Assign a task to a user
- [] Remove a task from a user
- [] Download a list of all users and tasks as a JSON
- [] Create a seeder for users and tasks


Notes:
- 1 user can have multiple tasks and the same task can be assigned to more than 1 user
- You can use Laravel's own migration for the users table, no need to create a new one
- There's a JSON file in the repo with a few example users and tasks which you can use to build your seeder file (so you don't have to come up with names, etc); when you build the download feature, the file structure should look the same as this one.
