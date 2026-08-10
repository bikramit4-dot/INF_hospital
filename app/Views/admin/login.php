<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($page_title); ?> | <?php echo e(SITE_NAME); ?></title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/admin.css?v=4">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="admin-body login-page">
  <div class="login-shell">
    <div class="login-card">
      <div class="login-brand">
        <span class="brand-mark">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 3h4v7h7v4h-7v7h-4v-7H3v-4h7V3Z"/></svg>
        </span>
        <span class="brand-text">
          <strong><?php echo e(SITE_NAME); ?></strong>
          <small>Admin Panel</small>
        </span>
      </div>

      <h1 class="login-title">Sign in</h1>
      <p class="login-sub">Manage the hospital website content securely.</p>

      <?php echo $message; ?>

      <form method="post" class="login-form">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required autocomplete="username" placeholder="Enter your username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
      </form>

      <div class="login-secure">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1 1 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1Z"/></svg>
        <span>Protected by CSRF tokens, login throttling &amp; session hardening.</span>
      </div>

      <a class="login-back" href="../index.php">&larr; Back to website</a>
    </div>
  </div>
</body>
</html>
