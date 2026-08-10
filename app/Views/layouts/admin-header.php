<?php
// ----------------------------------------------------------
// Shared admin layout — header
// Renders the sidebar navigation + sticky topbar for every
// page rendered via View::renderAdmin().
// ----------------------------------------------------------
use App\Models\Appointment;
use App\Models\CareerApplication;
use App\Models\Contact;
use App\Models\OnlineConsultation;

// Determine the active page. Views may pass an explicit $active
// key (e.g. 'departments'); otherwise fall back to the current script.
$active_page = $active ?? basename(parse_url($_SERVER['REQUEST_URI'] ?? '/admin/index.php', PHP_URL_PATH) ?? '', '.php');

// Sidebar notification badges (pending / unread counts).
$nav_badge = [
    'appointments' => (int) Appointment::count('status = :s', [':s' => 'pending']),
    'contacts' => (int) Contact::unreadCount(),
    'consultations' => (int) OnlineConsultation::pendingCount(),
    'applications' => (int) CareerApplication::pendingCount(),
];

$admin_nav = [
    ['key' => 'index', 'label' => 'Overview', 'icon' => 'grid', 'href' => 'index.php', 'section' => 'main'],
    ['key' => 'departments', 'label' => 'Departments', 'icon' => 'building', 'href' => 'departments.php', 'section' => 'main'],
    ['key' => 'doctors', 'label' => 'Doctors', 'icon' => 'stethoscope', 'href' => 'doctors.php', 'section' => 'main'],
    ['key' => 'services', 'label' => 'Services', 'icon' => 'activity', 'href' => 'services.php', 'section' => 'main'],
    ['key' => 'packages', 'label' => 'Health Packages', 'icon' => 'heart', 'href' => 'packages.php', 'section' => 'main'],
    ['key' => 'team-members', 'label' => 'Team Members', 'icon' => 'users', 'href' => 'team-members.php', 'section' => 'main'],
    ['key' => 'lab-reports', 'label' => 'Lab Reports', 'icon' => 'file', 'href' => 'lab-reports.php', 'section' => 'main'],
    ['key' => 'news', 'label' => 'News & Events', 'icon' => 'newspaper', 'href' => 'news.php', 'section' => 'main'],
    ['key' => 'pages', 'label' => 'Pages', 'icon' => 'layout', 'href' => 'pages.php', 'section' => 'main'],
    ['key' => 'appointments', 'label' => 'Appointments', 'icon' => 'calendar', 'href' => 'appointments.php', 'section' => 'inbox', 'badge' => $nav_badge['appointments']],
    ['key' => 'contacts', 'label' => 'Messages', 'icon' => 'mail', 'href' => 'contacts.php', 'section' => 'inbox', 'badge' => $nav_badge['contacts']],
    ['key' => 'consultations', 'label' => 'Consultations', 'icon' => 'video', 'href' => 'consultations.php', 'section' => 'inbox', 'badge' => $nav_badge['consultations']],
    ['key' => 'applications', 'label' => 'Applications', 'icon' => 'briefcase', 'href' => 'applications.php', 'section' => 'inbox', 'badge' => $nav_badge['applications']],
    ['key' => 'change-password', 'label' => 'Change Password', 'icon' => 'key', 'href' => 'change-password.php', 'section' => 'account'],
];

$nav_section_labels = [
    'main' => 'Main Menu',
    'inbox' => 'Inbox & Requests',
    'account' => 'Account',
];

function admin_icon(string $name): string
{
    static $icons = [
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
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
        'cross' => '<path d="M10 3h4v7h7v4h-7v7h-4v-7H3v-4h7V3Z"/>',
        'shield' => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1 1 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1Z"/>',
        'menu' => '<line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/>',
        'plus' => '<path d="M5 12h14"/><path d="M12 5v14"/>',
        'inbox' => '<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>',
        'message' => '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>',
        'file' => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'edit' => '<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'arrow' => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'activity' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
        'layout' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>',
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
  <title><?php echo e($page_title ?? 'Admin'); ?> | <?php echo e(SITE_NAME); ?> Admin</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/admin.css?v=3">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
<div class="admin-shell">

  <!-- ===== Sidebar ===== -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
      <span class="brand-mark"><?php echo admin_icon('cross'); ?></span>
      <span class="brand-text">
        <strong><?php echo e(SITE_NAME); ?></strong>
        <small>Admin Panel</small>
      </span>
    </div>

    <nav class="sidebar-nav" aria-label="Admin navigation">
      <?php
      $current_section = '';
      foreach ($admin_nav as $item) {
          if ($item['section'] !== $current_section) {
              $current_section = $item['section'];
              echo '<div class="nav-section">' . e($nav_section_labels[$current_section] ?? ucfirst($current_section)) . '</div>';
          }
          $is_active = ($active_page === $item['key']);
          $badge = !empty($item['badge']) ? (int) $item['badge'] : 0;
      ?>
      <a class="nav-item<?php echo $is_active ? ' active' : ''; ?>" href="<?php echo e($item['href']); ?>">
        <?php echo admin_icon($item['icon']); ?>
        <span><?php echo e($item['label']); ?></span>
        <?php if (isset($item['badge'])): ?>
          <span class="nav-badge<?php echo $badge === 0 ? ' nav-badge-zero' : ''; ?>"><?php echo $badge; ?></span>
        <?php endif; ?>
      </a>
      <?php } ?>
      <div class="nav-section">Account</div>
      <a class="nav-item nav-danger" href="logout.php">
        <?php echo admin_icon('logout'); ?>
        <span>Sign Out</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <a class="sidebar-site-link" href="../index.php" target="_blank" rel="noopener">
        <?php echo admin_icon('external'); ?>
        <span>View Website</span>
      </a>
      <span class="sidebar-user">Signed in as<br><strong><?php echo e($_SESSION['admin_user'] ?? 'admin'); ?></strong></span>
    </div>
  </aside>
  <div class="sidebar-scrim" id="sidebarScrim"></div>

  <!-- ===== Main column ===== -->
  <div class="admin-main">
    <header class="admin-topbar">
      <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle navigation menu">
        <?php echo admin_icon('menu'); ?>
      </button>
      <h1 class="page-title"><?php echo e($page_title ?? 'Admin'); ?></h1>
      <div class="topbar-actions">
        <a class="topbar-site" href="../index.php" target="_blank" rel="noopener">
          <?php echo admin_icon('external'); ?>
          <span>View Site</span>
        </a>
        <span class="topbar-user">
          <span class="avatar"><?php echo e(strtoupper(mb_substr($_SESSION['admin_user'] ?? 'A', 0, 1))); ?></span>
          <?php echo e($_SESSION['admin_user'] ?? 'admin'); ?>
        </span>
        <a href="logout.php" class="btn btn-sm btn-danger">Sign Out</a>
      </div>
    </header>

    <main class="admin-content">
