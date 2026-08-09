<section class="page-banner">
  <div class="container">
    <h1>Management Team</h1>
    <div class="breadcrumb"><a href="index.php">Home</a> / Management Team</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span>Leadership</span>
      <h2>Meet Our Management Team</h2>
      <p>Experienced leaders guiding our hospital's mission to deliver exceptional healthcare.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($team as $member): ?>
      <div class="doctor-card">
        <div class="doctor-photo">👤</div>
        <div class="doctor-info">
          <h3><?php echo e($member['name']); ?></h3>
          <p><?php echo e($member['role']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>