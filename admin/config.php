<?php

declare(strict_types=1);

// Hostinger: upload this repo to public_html. This folder is your admin area.
// 1) Generate a password hash locally:
//    php -r 'echo password_hash("REPLACE_WITH_YOUR_PASSWORD", PASSWORD_DEFAULT), PHP_EOL;'
// 2) Paste the hash into ADMIN_PASSWORD_HASH below.
//
// Never store the plain password in this repo.

const ADMIN_USERNAME = 'admin';
const ADMIN_PASSWORD_HASH = 'CHANGE_ME';
const SESSION_NAME = 'ai_club_admin';

