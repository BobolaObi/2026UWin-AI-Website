<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

start_admin_session();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim((string) $_POST['username']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

    $is_valid_user = hash_equals(ADMIN_USERNAME, $username);
    $is_valid_password = $is_valid_user && password_verify($password, ADMIN_PASSWORD_HASH);

    if ($is_valid_password) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        header('Location: /admin/index.php', true, 302);
        exit;
    }

    // Slow down brute-force attempts a little without revealing what failed.
    usleep(350000);
    $error = 'Invalid credentials.';
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="/style.css" />
    <style>
      body { background: #0E1B2A; color: #f8fafc; }
      .login-shell { max-width: 520px; margin: 0 auto; padding: 56px 18px; width: 100%; }
      .login-card { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 18px; padding: 22px; box-shadow: 0 22px 60px rgba(0,0,0,.28); }
      .login-card h1 { margin: 0 0 14px; letter-spacing: -.02em; }
      .login-card label { display: block; font-weight: 700; margin: 12px 0 6px; }
      .login-card input { width: 100%; border-radius: 12px; border: 1px solid rgba(255,255,255,.18); background: rgba(255,255,255,.08); color: #f8fafc; padding: 12px 14px; font: inherit; }
      .login-card input:focus { outline: 2px solid rgba(255,206,0,.9); outline-offset: 2px; }
      .login-actions { display: flex; gap: 10px; margin-top: 16px; }
      .login-actions button { width: 100%; border: 0; cursor: pointer; }
      .login-error { margin-top: 12px; color: #ffd6d6; font-weight: 700; }
      .login-note { margin-top: 12px; opacity: .85; font-size: 14px; line-height: 1.45; }
      a { color: #FFCE00; }
    </style>
  </head>
  <body>
    <div class="login-shell">
      <div class="login-card">
        <h1>Admin login</h1>
        <form method="post" action="/admin/login.php" autocomplete="off">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" inputmode="text" required />

          <label for="password">Password</label>
          <input id="password" name="password" type="password" required />

          <div class="login-actions">
            <button class="btn primary breath" type="submit">Sign in</button>
          </div>

          <?php if ($error !== ''): ?>
            <div class="login-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </form>

        <p class="login-note">
          If you see an error after uploading to Hostinger, confirm your hosting plan supports PHP.
        </p>
      </div>
    </div>
  </body>
</html>

