<?php
$stats_meta = [
    ['label' => 'Departments', 'value' => $stats['departments'], 'href' => 'departments.php', 'icon' => 'building', 'tint' => 'tint-dark'],
    ['label' => 'Doctors', 'value' => $stats['doctors'], 'href' => 'doctors.php', 'icon' => 'stethoscope', 'tint' => 'tint-red'],
    ['label' => 'Services', 'value' => $stats['services'], 'href' => 'services.php', 'icon' => 'activity', 'tint' => 'tint-green'],
    ['label' => 'Health Packages', 'value' => $stats['packages'], 'href' => 'packages.php', 'icon' => 'heart', 'tint' => 'tint-blue'],
    ['label' => 'Team Members', 'value' => $stats['team'], 'href' => 'team-members.php', 'icon' => 'users', 'tint' => 'tint-dark'],
    ['label' => 'Lab Reports', 'value' => $stats['lab_reports'], 'href' => 'lab-reports.php', 'icon' => 'file', 'tint' => 'tint-purple'],
    ['label' => 'News Items', 'value' => $stats['news'], 'href' => 'news.php', 'icon' => 'newspaper', 'tint' => 'tint-purple'],
    ['label' => 'Pending Appointments', 'value' => $stats['appointments'], 'href' => 'appointments.php', 'icon' => 'calendar', 'tint' => 'tint-amber', 'note' => 'awaiting review'],
    ['label' => 'Unread Messages', 'value' => $stats['contacts'], 'href' => 'contacts.php', 'icon' => 'mail', 'tint' => 'tint-green', 'note' => 'in your inbox'],
    ['label' => 'Consultations', 'value' => $stats['consultations'], 'href' => 'consultations.php', 'icon' => 'video', 'tint' => 'tint-blue', 'note' => 'pending'],
    ['label' => 'Job Applications', 'value' => $stats['applications'], 'href' => 'applications.php', 'icon' => 'briefcase', 'tint' => 'tint-purple', 'note' => 'pending'],
];
?>
<div class="page-head">
  <div>
    <h1>Admin Dashboard</h1>
    <p>Manage the hospital website content from one secure place.</p>
  </div>
  <a href="../index.php" class="btn btn-sm btn-outline-dark" target="_blank" rel="noopener">View Website</a>
</div>

<div class="stat-grid">
  <?php foreach ($stats_meta as $stat): ?>
  <div class="stat-card">
    <a class="stat-link" href="<?php echo e($stat['href']); ?>" aria-label="Open <?php echo e($stat['label']); ?>"></a>
    <div class="stat-top">
      <span class="stat-icon <?php echo e($stat['tint']); ?>"><?php echo admin_icon($stat['icon']); ?></span>
      <span class="stat-value"><?php echo (int) $stat['value']; ?></span>
    </div>
    <div>
      <div class="stat-label"><?php echo e($stat['label']); ?></div>
      <?php if (!empty($stat['note'])): ?><div class="stat-note"><?php echo e($stat['note']); ?></div><?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="dash-cols">
  <div class="card">
    <div class="card-head">
      <h3>Recent Appointments</h3>
      <a href="appointments.php" class="btn btn-sm btn-ghost">View all</a>
    </div>
    <?php if (empty($recent_appointments)): ?>
      <div class="empty-state">
        <span class="empty-icon"><?php echo admin_icon('calendar'); ?></span>
        <p>No appointment requests yet.</p>
        <small>Requests will appear here as patients book.</small>
      </div>
    <?php else: ?>
      <div class="recent-list">
        <?php foreach ($recent_appointments as $appt): ?>
        <div class="recent-item">
          <span class="ri-icon"><?php echo admin_icon('calendar'); ?></span>
          <div class="ri-body">
            <div class="ri-title"><?php echo e($appt['patient_name']); ?> <span class="cell-muted">· <?php echo e($appt['booking_ref']); ?></span></div>
            <div class="ri-sub"><?php echo e($appt['doctor_name'] ?? '—'); ?> · <?php echo e($appt['appointment_date']); ?> at <?php echo e($appt['appointment_time']); ?></div>
          </div>
          <span class="badge badge-<?php echo e($appt['status']); ?>"><?php echo e($appt['status']); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="card">
    <div class="card-head">
      <h3>Recent Messages</h3>
      <a href="contacts.php" class="btn btn-sm btn-ghost">View all</a>
    </div>
    <?php if (empty($recent_messages)): ?>
      <div class="empty-state">
        <span class="empty-icon"><?php echo admin_icon('mail'); ?></span>
        <p>No contact messages yet.</p>
        <small>Messages from the contact form will appear here.</small>
      </div>
    <?php else: ?>
      <div class="recent-list">
        <?php foreach ($recent_messages as $msg): ?>
        <div class="recent-item">
          <span class="ri-icon"><?php echo admin_icon('message'); ?></span>
          <div class="ri-body">
            <div class="ri-title"><?php echo e($msg['name']); ?> <span class="cell-muted">· <?php echo e($msg['subject'] ?? 'No subject'); ?></span></div>
            <div class="ri-sub"><?php echo e(mb_strimwidth($msg['message'], 0, 64, '…')); ?></div>
          </div>
          <span class="badge <?php echo $msg['is_read'] ? 'badge-read' : 'badge-unread'; ?>"><?php echo $msg['is_read'] ? 'read' : 'unread'; ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="dash-cols">
  <div class="card">
    <div class="card-head"><h3>Quick Actions</h3></div>
    <div class="quick-links">
      <a class="quick-link" href="departments.php"><span class="ql-icon"><?php echo admin_icon('building'); ?></span>Add Department</a>
      <a class="quick-link" href="doctors.php"><span class="ql-icon"><?php echo admin_icon('stethoscope'); ?></span>Add Doctor</a>
      <a class="quick-link" href="services.php"><span class="ql-icon"><?php echo admin_icon('activity'); ?></span>Add Service</a>
      <a class="quick-link" href="packages.php"><span class="ql-icon"><?php echo admin_icon('heart'); ?></span>Add Package</a>
      <a class="quick-link" href="team-members.php"><span class="ql-icon"><?php echo admin_icon('users'); ?></span>Add Team Member</a>
      <a class="quick-link" href="lab-reports.php"><span class="ql-icon"><?php echo admin_icon('file'); ?></span>Add Lab Report</a>
      <a class="quick-link" href="news.php"><span class="ql-icon"><?php echo admin_icon('newspaper'); ?></span>Add News</a>
      <a class="quick-link" href="pages.php"><span class="ql-icon"><?php echo admin_icon('layout'); ?></span>Edit Page Content</a>
      <a class="quick-link" href="appointments.php"><span class="ql-icon"><?php echo admin_icon('calendar'); ?></span>Review Appointments</a>
      <a class="quick-link" href="contacts.php"><span class="ql-icon"><?php echo admin_icon('mail'); ?></span>Read Messages</a>
    </div>
  </div>

  <div class="card security-card">
    <span class="sec-icon"><?php echo admin_icon('shield'); ?></span>
    <div>
      <h3>Security</h3>
      <p>This admin area uses password hashing, session regeneration, CSRF protection, brute-force login throttling, and hardened security headers. Keep your admin password strong and change it regularly.</p>
    </div>
  </div>
</div>
