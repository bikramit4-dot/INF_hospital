<section class="page-banner">
  <div class="container">
    <h1><?php echo e(content('departments', 'banner_title')); ?></h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Departments</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span><?php echo e(content('departments', 'dept_kicker')); ?></span>
      <h2><?php echo e(content('departments', 'dept_title')); ?></h2>
      <p><?php echo e(content('departments', 'dept_text')); ?></p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($departments as $dept): ?>
      <div class="card">
        <?php if (!empty($dept['image_url'])): ?>
        <div class="dept-photo"><img src="<?php echo e($dept['image_url']); ?>" alt="<?php echo e($dept['name']); ?>"></div>
        <?php else: ?>
        <div class="icon"><?php echo e($dept['icon']); ?></div>
        <?php endif; ?>
        <h3><?php echo e($dept['name']); ?></h3>
        <p><?php echo e($dept['description']); ?></p>
        <p class="mt-20"><a href="<?php echo e(site_url('pages/find-doctor.php?by=department&dept=' . urlencode($dept['name']))); ?>" style="color:var(--primary); font-weight:600;">View Doctors →</a></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>