<?php
// ----------------------------------------------------------
// Shared admin layout — header
// Wellness-style: sticky top bar (brand + actions) and a
// horizontal section nav. Rendered via View::renderAdmin().
// ----------------------------------------------------------
use App\Models\Appointment;
use App\Models\CareerApplication;
use App\Models\Contact;
use App\Models\OnlineConsultation;

// Determine the active page. Views may pass an explicit $active
// key (e.g. 'departments'); otherwise fall back to the current script.
$active_page = $active ?? basename(parse_url($_SERVER['REQUEST_URI'] ?? '/admin/index.php', PHP_URL_PATH) ?? '', '.php');

// Nav badge counts (pending / unread).
$nav_badge = [
    'appointments' => (int) Appointment::count('status = :s', [':s' => 'pending']),
    'contacts' => (int) Contact::unreadCount(),
    'consultations' => (int) OnlineConsultation::pendingCount(),
    'applications' => (int) CareerApplication::pendingCount(),
];

$admin_nav = [
    ['key' => 'index', 'label' => 'Dashboard', 'href' => 'index.php'],
    ['key' => 'pages', 'label' => 'Pages', 'href' => 'pages.php'],
    ['key' => 'departments', 'label' => 'Departments', 'href' => 'departments.php'],
    ['key' => 'doctors', 'label' => 'Doctors', 'href' => 'doctors.php'],
    ['key' => 'services', 'label' => 'Services', 'href' => 'services.php'],
    ['key' => 'packages', 'label' => 'Health Packages', 'href' => 'packages.php'],
    ['key' => 'team-members', 'label' => 'Team Members', 'href' => 'team-members.php'],
    ['key' => 'lab-reports', 'label' => 'Lab Reports', 'href' => 'lab-reports.php'],
    ['key' => 'news', 'label' => 'News & Events', 'href' => 'news.php'],
    ['key' => 'appointments', 'label' => 'Appointments', 'href' => 'appointments.php', 'badge' => $nav_badge['appointments']],
    ['key' => 'contacts', 'label' => 'Messages', 'href' => 'contacts.php', 'badge' => $nav_badge['contacts']],
    ['key' => 'consultations', 'label' => 'Consultations', 'href' => 'consultations.php', 'badge' => $nav_badge['consultations']],
    ['key' => 'applications', 'label' => 'Applications', 'href' => 'applications.php', 'badge' => $nav_badge['applications']],
    ['key' => 'change-password', 'label' => 'Password', 'href' => 'change-password.php'],
];

function admin_icon(string $name): string
{
    static $icons = [
        'cross' => '<path d="M10 3h4v7h7v4h-7v7h-4v-7H3v-4h7V3Z"/>',
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
        'layout' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>',
        'building' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M12 6h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M12 10h.01"/><path d="M16 10h.01"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/>',
        'stethoscope' => '<path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6 6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6 6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/>',
        'heart' => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"/>',
        'newspaper' => '<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/>',
        'mail' => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'video' => '<path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/>',
        'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'key' => '<path d="m21 2-9.6 9.6"/><circle cx="7.5" cy="15.5" r="5.5"/><path d="m15.5 7.5 3 3L22 7l-3-3"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
        'external' => '<path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>',
        'shield' => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1 1 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1Z"/>',
        'plus' => '<path d="M5 12h14"/><path d="M12 5v14"/>',
        'inbox' => '<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>',
        'message' => '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>',
        'file' => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'edit' => '<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'arrow' => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'zap' => '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'activity' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
        'trash' => '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>',
    ];
    $body = $icons[$name] ?? $icons['grid'];
    return '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $body . '</svg>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title><?php echo e($page_title ?? 'Admin'); ?> | <?php echo e(SITE_NAME); ?> Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/admin.css?v=6">
</head>
<body class="admin-body">

  <!-- ===== Top bar ===== -->
  <header class="admin-topbar">
    <div class="admin-topbar-inner">
      <a class="brand" href="index.php">
        <span class="brand-mark"><?php echo admin_icon('cross'); ?></span>
        <span class="brand-text"><strong><?php echo e(SITE_NAME); ?> <em>Admin</em></strong></span>
      </a>
      <div class="admin-topbar-actions">
        <a class="admin-link" href="index.php">Dashboard</a>
        <a class="admin-link" href="../index.php" target="_blank" rel="noopener">View Site</a>
        <span class="admin-user">Signed in as <strong><?php echo e($_SESSION['admin_user'] ?? 'admin'); ?></strong></span>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
      </div>
    </div>
  </header>

  <!-- ===== Section nav ===== -->
  <nav class="admin-nav" aria-label="Admin sections">
    <div class="admin-nav-inner">
      <?php foreach ($admin_nav as $item):
          $is_active = ($active_page === $item['key']);
          $badge = !empty($item['badge']) ? (int) $item['badge'] : 0;
      ?>
      <a class="<?php echo $is_active ? 'active' : ''; ?>" href="<?php echo e($item['href']); ?>">
        <span><?php echo e($item['label']); ?></span>
        <?php if (isset($item['badge'])): ?>
          <span class="nav-badge<?php echo $badge === 0 ? ' nav-badge-zero' : ''; ?>"><?php echo $badge; ?></span>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
  </nav>

  <!-- ===== Main ===== -->
  <main class="admin-main">
    <div class="admin-content">
