<section class="page-banner">
  <div class="container">
    <h1><?php echo e(content('health-packages', 'banner_title')); ?></h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Health Packages</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span><?php echo e(content('health-packages', 'packages_kicker')); ?></span>
      <h2><?php echo e(content('health-packages', 'packages_title')); ?></h2>
      <p><?php echo e(content('health-packages', 'packages_text')); ?></p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($health_packages as $pkg): ?>
      <div class="card">
        <h3><?php echo e($pkg['name']); ?></h3>
        <p class="mb-20"><?php echo e($pkg['includes_text']); ?></p>
        <strong style="color:var(--primary); font-size:18px; display:block; margin-bottom:16px;"><?php echo e($pkg['price']); ?></strong>
        <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn btn-secondary">Book This Package</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>