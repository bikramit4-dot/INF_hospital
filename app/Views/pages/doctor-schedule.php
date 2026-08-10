<section class="page-banner">
  <div class="container">
    <h1><?php echo e(content('doctor-schedule', 'banner_title')); ?></h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Doctor Schedule</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span><?php echo e(content('doctor-schedule', 'ds_kicker')); ?></span>
      <h2><?php echo e(content('doctor-schedule', 'ds_title')); ?></h2>
      <p><?php echo e(content('doctor-schedule', 'ds_text')); ?></p>
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
          <td><a href="<?php echo e(site_url('pages/book-appointment.php?doctor=' . urlencode($doc['name']))); ?>" style="color:var(--primary); font-weight:600;">Book</a></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</section>