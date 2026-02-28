<?php

declare(strict_types=1);

// Hostinger setup:
// - Put DB credentials in admin/config.local.php (this file is gitignored).
// - Create tables using admin/schema.sql in phpMyAdmin.
// - Add admin users by inserting into admin_users (password_hash via password_hash()).

const SESSION_NAME = 'ai_club_admin';

const DB_HOST = 'CHANGE_ME';
const DB_NAME = 'CHANGE_ME';
const DB_USER = 'CHANGE_ME';
const DB_PASSWORD = 'CHANGE_ME';
const DB_CHARSET = 'utf8mb4';

if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}
