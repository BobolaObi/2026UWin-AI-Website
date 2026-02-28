<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

require_admin_login();

$username = current_admin_username();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin</title>
    <link rel="stylesheet" href="/style.css" />
    <style>
      body { background: #f4f7fb; }
      .admin-shell { max-width: 980px; margin: 0 auto; padding: 28px 18px 56px; width: 100%; }
      .admin-card { background: #fff; border: 1px solid rgba(14,27,42,.12); border-radius: 18px; padding: 18px 18px 16px; box-shadow: 0 18px 44px rgba(0,0,0,.08); }
      .admin-top { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 12px; }
      .admin-top h1 { margin: 0; letter-spacing: -.02em; }
      .admin-links { display: flex; gap: 10px; flex-wrap: wrap; }
      .admin-links a { text-decoration: none; }
      .admin-note { color: #394867; margin: 0; line-height: 1.5; }
      code { background: rgba(0,85,150,.06); padding: 2px 6px; border-radius: 8px; }
    </style>
  </head>
  <body>
    <div class="admin-shell">
      <div class="admin-card">
        <div class="admin-top">
          <h1>Admin</h1>
          <div class="admin-links">
            <a class="btn secondary" href="/index.html">View site</a>
            <a class="btn primary breath" href="/admin/logout.php">Log out</a>
          </div>
        </div>
        <p class="admin-note">
          Logged in as <code><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></code>.
          Next step: wire your form submissions into a database + build an editor here.
          Tell me what fields you want, and whether you want to edit “submissions” or the “form questions”.
        </p>
      </div>
    </div>
  </body>
</html>
