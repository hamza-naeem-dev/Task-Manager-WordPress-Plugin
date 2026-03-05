Task Manager Plugin
Description

The Task Manager Plugin is a custom WordPress plugin that allows users to create and manage tasks from the frontend of a website. The plugin uses a shortcode to display a task submission form where users can enter task details and select a task status. Submitted tasks are stored as a Custom Post Type and displayed on a separate page.

The plugin also allows users to update the task status directly from the frontend using an edit feature.

Features

Custom WordPress plugin built using OOP structure

Registers a Custom Post Type (Tasks)

Frontend task submission form using shortcode

Nonce verification to protect against CSRF attacks

Input sanitization for security

Stores task status using post meta

Displays tasks using WP_Query

Allows users to edit and update task status

How It Works

The plugin registers a Custom Post Type called "Tasks".

A shortcode [tm_form] displays a form where users can submit new tasks.

When the form is submitted:

A nonce verification is performed.

Input data is sanitized.

The task is saved using wp_insert_post().

Tasks are displayed on another page using the shortcode [tm_list].

Each task includes an Edit button that allows users to update the task status.

Task status is updated using update_post_meta().

Shortcodes
Display Task Submission Form
[tm_form]
Display Task List
[tm_list]
Security Measures

The plugin implements several security best practices:

Prevents direct file access using ABSPATH

Uses WordPress nonces to protect forms

Sanitizes user inputs before saving to the database

Validates allowed task status values

Technologies Used

WordPress Plugin Development

PHP

WordPress Hooks

Custom Post Types

WP_Query

WordPress Security Functions

Author

Hamza Naeem
