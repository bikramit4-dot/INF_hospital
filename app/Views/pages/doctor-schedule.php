<section class="page-banner">
  <div class="container">
    <h1>Doctor Schedule</h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('index.php')); ?>">Home</a> / Doctor Schedule</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span>Availability</span>
      <h2>Weekly Doctor Schedule</h2>
      <p>Check availability before booking your appointment.</p>
    </div>
    <div class="table-scroll">
      <table>
        <tr><th>Doctor</th><th>Department</th><th>Available Days</th><th>Time</th><th></th></tr>
        <?php foreach ($doctors as $doc): ?>
        <tr>
          <td><?php echo e($doc['name']); ?></td>
          <td><?php echo e($doc['department_name']); ?></td>
          <td><?php echo e($doc['days']); ?></td>
          <td><?php echo e($doc['time_slot']); ?></td>
          <td><a href="<?php echo e(site_url('book-appointment.php?doctor=' . urlencode($doc['name']))); ?>" style="color:var(--primary); font-weight:600;">Book</a></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</section>