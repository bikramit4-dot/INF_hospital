<?php
$admin_name = e($_SESSION['admin_user'] ?? 'Admin');
$today_label = date('l, F j, Y');
$pending = (int) $stats['appointments'];
$unread = (int) $stats['contacts'];
$content_registry = require dirname(__DIR__, 3) . '/includes/page-content-registry.php';
$pages_count = count($content_registry['pages']);

$overview_stats = [
    ['label' => 'Departments', 'value' => $stats['departments'], 'href' => 'departments.php', 'icon' => 'building', 'tint' => 'stat-total'],
    ['label' => 'Doctors', 'value' => $stats['doctors'], 'href' => 'doctors.php', 'icon' => 'stethoscope', 'tint' => 'stat-total'],
    ['label' => 'Services', 'value' => $stats['services'], 'href' => 'services.php', 'icon' => 'activity', 'tint' => 'stat-confirmed'],
    ['label' => 'Health Packages', 'value' => $stats['packages'], 'href' => 'packages.php', 'icon' => 'heart', 'tint' => 'stat-new'],
    ['label' => 'Team Members', 'value' => $stats['team'], 'href' => 'team-members.php', 'icon' => 'users', 'tint' => 'stat-completed'],
    ['label' => 'News Items', 'value' => $stats['news'], 'href' => 'news.php', 'icon' => 'newspaper', 'tint' => 'stat-total'],
    ['label' => 'Lab Reports', 'value' => $stats['lab_reports'], 'href' => 'lab-reports.php', 'icon' => 'file', 'tint' => 'stat-confirmed'],
];

$quick_links = [
    ['label' => 'Add Department', 'href' => 'departments.php', 'icon' => 'building'],
    ['label' => 'Add Doctor', 'href' => 'doctors.php', 'icon' => 'stethoscope'],
    ['label' => 'Add Service', 'href' => 'services.php', 'icon' => 'activity'],
    ['label' => 'Add Package', 'href' => 'packages.php', 'icon' => 'heart'],
    ['label' => 'Add News', 'href' => 'news.php', 'icon' => 'newspaper'],
    ['label' => 'Edit Page Content', 'href' => 'pages.php', 'icon' => 'layout'],
    ['label' => 'Review Appointments', 'href' => 'appointments.php', 'icon' => 'calendar'],
    ['label' => 'Read Messages', 'href' => 'contacts.php', 'icon' => 'mail'],
];

$manage_cards = [
    ['label' => 'Departments', 'href' => 'departments.php', 'icon' => 'building', 'count' => $stats['departments']],
    ['label' => 'Doctors', 'href' => 'doctors.php', 'icon' => 'stethoscope', 'count' => $stats['doctors']],
    ['label' => 'Services', 'href' => 'services.php', 'icon' => 'activity', 'count' => $stats['services']],
    ['label' => 'Health Packages', 'href' => 'packages.php', 'icon' => 'heart', 'count' => $stats['packages']],
    ['label' => 'Team Members', 'href' => 'team-members.php', 'icon' => 'users', 'count' => $stats['team']],
    ['label' => 'Lab Reports', 'href' => 'lab-reports.php', 'icon' => 'file', 'count' => $stats['lab_reports']],
    ['label' => 'News & Events', 'href' => 'news.php', 'icon' => 'newspaper', 'count' => $stats['news']],
    ['label' => 'Website Pages', 'href' => 'pages.php', 'icon' => 'layout', 'count' => $pages_count],
];
?>
<!-- ===== Welcome hero ===== -->
<div class="dash-hero">
  <div class="dash-hero-deco" aria-hidden="true"><?php echo admin_icon('cross'); ?></div>
  <div class="dash-hero-content">
    <span class="dash-hero-kicker">Admin Panel</span>
    <h1>Welcome back, <?php echo $admin_name; ?></h1>
    <p class="dash-hero-meta">
      <?php echo admin_icon('calendar'); ?>
      <?php echo e($today_label); ?>
      &nbsp;&middot;&nbsp;
      <span class="dash-hero-new"><?php echo $pending; ?> pending appointment<?php echo $pending === 1 ? '' : 's'; ?></span>
      and <span class="dash-hero-new"><?php echo $unread; ?> unread message<?php echo $unread === 1 ? '' : 's'; ?></span>
      waiting for you
    </p>
  </div>
  <div class="dash-hero-actions">
    <a class="btn btn-light btn-sm" href="appointments.php">All Appointments</a>
    <a class="btn btn-primary btn-sm" href="pages.php">Edit Pages</a>
    <a class="btn dash-hero-ghost btn-sm" href="../index.php" target="_blank" rel="noopener">View Site</a>
  </div>
</div>

<!-- ===== Overview stats ===== -->
<div class="admin-stats">
  <?php foreach ($overview_stats as $stat): ?>
  <div class="admin-stat">
    <span class="stat-icon <?php echo e($stat['tint']); ?>"><?php echo admin_icon($stat['icon']); ?></span>
    <div class="stat-body">
      <strong><?php echo (int) $stat['value']; ?></strong>
      <span><?php echo e($stat['label']); ?></span>
    </div>
    <a class="stat-trend" href="<?php echo e($stat['href']); ?>">Manage &rarr;</a>
  </div>
  <?php endforeach; ?>
</div>

<div class="dash-grid">
  <!-- ===== Recent appointments ===== -->
  <section class="dash-panel">
    <div class="dash-panel-head">
      <h2>Recent Appointments</h2>
      <a href="appointments.php">View all &rarr;</a>
    </div>
    <?php if (empty($recent_appointments)): ?>
      <p class="dash-empty">No appointment requests yet. New bookings from the website will appear here.</p>
    <?php else: ?>
      <ul class="dash-recent">
        <?php foreach ($recent_appointments as $i => $appt): ?>
        <li>
          <span class="avatar a<?php echo 1 + ($i % 6); ?>"><?php echo e(strtoupper(mb_substr($appt['patient_name'], 0, 2))); ?></span>
          <div class="dash-recent-info">
            <strong><?php echo e($appt['patient_name']); ?></strong>
            <span><?php echo e($appt['doctor_name'] ?? '—'); ?> &middot; <?php echo e($appt['appointment_date']); ?> at <?php echo e($appt['appointment_time']); ?></span>
          </div>
          <span class="badge badge-<?php echo e($appt['status']); ?>"><i class="badge-dot"></i><?php echo e($appt['status']); ?></span>
        </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>

  <!-- ===== Recent messages ===== -->
  <section class="dash-panel">
    <div class="dash-panel-head">
      <h2>Recent Messages</h2>
      <a href="contacts.php">View all &rarr;</a>
    </div>
    <?php if (empty($recent_messages)): ?>
      <p class="dash-empty">No contact messages yet. Messages from the contact form will appear here.</p>
    <?php else: ?>
      <ul class="dash-recent">
        <?php foreach ($recent_messages as $i => $msg): ?>
        <li>
          <span class="avatar a<?php echo 1 + (($i + 3) % 6); ?>"><?php echo e(strtoupper(mb_substr($msg['name'], 0, 2))); ?></span>
          <div class="dash-recent-info">
            <strong><?php echo e($msg['name']); ?></strong>
            <span><?php echo e(mb_strimwidth($msg['message'], 0, 60, '…')); ?></span>
          </div>
          <span class="badge <?php echo $msg['is_read'] ? 'badge-read' : 'badge-unread'; ?>"><i class="badge-dot"></i><?php echo $msg['is_read'] ? 'read' : 'unread'; ?></span>
        </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
</div>

<!-- ===== Quick actions ===== -->
<div class="dash-quick">
  <?php foreach ($quick_links as $link): ?>
  <a class="quick-link" href="<?php echo e($link['href']); ?>">
    <span class="quick-link-icon"><?php echo admin_icon($link['icon']); ?></span>
    <?php echo e($link['label']); ?>
  </a>
  <?php endforeach; ?>
</div>

<!-- ===== Manage content ===== -->
<section class="dash-panel">
  <div class="dash-panel-head">
    <h2>Manage Content</h2>
    <a href="pages.php">Open page editor &rarr;</a>
  </div>
  <div class="content-grid">
    <?php foreach ($manage_cards as $card): ?>
    <a class="content-card" href="<?php echo e($card['href']); ?>">
      <span class="content-card-icon"><?php echo admin_icon($card['icon']); ?></span>
      <div>
        <h3><?php echo e($card['label']); ?></h3>
        <p><?php echo (int) $card['count']; ?> item<?php echo (int) $card['count'] === 1 ? '' : 's'; ?></p>
      </div>
      <span class="content-card-arrow"><?php echo admin_icon('chevron-right'); ?></span>
    </a>
    <?php endforeach; ?>
  </div>
</section>
