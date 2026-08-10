<?php
if (!isset($departments)) { require_once __DIR__ . '/config.php'; }
$current = basename($_SERVER['PHP_SELF']);
function header_nav_active(string $link, string $current): string
{
    $page = basename(parse_url($link, PHP_URL_PATH) ?: '');
    return ($page === $current) ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e(isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME); ?></title>
<link rel="stylesheet" href="<?php echo e(site_url('css/style.css?v=15')); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="site">

<!-- Top utility bar -->
<div class="topbar">
  <div class="container topbar-inner">
    <div class="topbar-left">
      <span>📍 <?php echo e(content('global', 'address')); ?></span>
      <span class="topbar-hide-sm">✉️ <a href="mailto:<?php echo e(content('global', 'email')); ?>"><?php echo e(content('global', 'email')); ?></a></span>
      <span class="topbar-hide-sm">📞 <a href="tel:<?php echo e(content('global', 'phone')); ?>"><?php echo e(content('global', 'phone')); ?></a></span>
    </div>
    <div class="topbar-right">
      <span class="topbar-hide-sm">🕐 <?php echo e(content('global', 'topbar_hours')); ?></span>
      <span class="emergency">🚑 Emergency: <?php echo e(content('global', 'emergency')); ?></span>
    </div>
  </div>
</div>

<!-- Main header: brand + quick actions -->
<header class="site-header">
  <div class="container header-main">
    <a href="<?php echo e(site_url('pages/index.php')); ?>" class="logo" aria-label="<?php echo e(SITE_NAME); ?>">
      <img src="<?php echo e(site_url('images/logo.png')); ?>" alt="<?php echo e(SITE_NAME); ?>" class="logo-img">
    </a>

    <div class="header-actions">
      <a href="tel:<?php echo e(content('global', 'emergency')); ?>" class="header-call">
        <span class="header-call-icon">📞</span>
        <span class="header-call-text">
          <small>Call Us 24/7</small>
          <?php echo e(content('global', 'emergency')); ?>
        </span>
      </a>
      <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn btn-primary nav-cta">Book Appointment</a>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">☰</button>
    </div>
  </div>

  <!-- Navigation bar -->
  <nav class="main-nav" id="mainNav">
    <div class="container nav-inner">
      <ul class="nav-list">
        <?php foreach ($nav_menu as $label => $item): ?>
        <li class="has-dropdown<?php echo header_nav_active($item['link'], $current); ?>">
          <a href="<?php echo e(site_url('pages/' . $item['link'])); ?>">
            <?php echo e($label); ?>
            <?php if (!empty($item['children'])): ?><span class="caret">▾</span><?php endif; ?>
          </a>
          <?php if (!empty($item['children'])): ?>
          <ul class="dropdown">
            <?php foreach ($item['children'] as $clabel => $clink): ?>
            <li><a href="<?php echo e($clink); ?>"><?php echo e($clabel); ?></a></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>
</header>
