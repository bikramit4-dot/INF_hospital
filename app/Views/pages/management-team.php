<!-- Page banner -->
<section class="page-banner page-banner-image">
  <div class="container">
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="800"><a href="index.php">Home</a> / Management Team</div>
    <h1 data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">Management Team</h1>
    <p data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">The experienced leaders guiding our mission of compassionate, world-class healthcare.</p>
  </div>
</section>

<!-- Team -->
<section class="section">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span>Leadership</span>
      <h2>Meet Our Management Team</h2>
      <p>Experienced leaders guiding our hospital's mission to deliver exceptional healthcare.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($team as $i => $member): ?>
      <div class="card team-card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="<?php echo ($i % 3) * 100; ?>">
        <?php if (!empty($member['photo_url'])): ?>
        <div class="team-photo">
          <img src="<?php echo e(site_url($member['photo_url'])); ?>" alt="Portrait of <?php echo e($member['name']); ?>">
        </div>
        <?php else: ?>
        <div class="team-photo team-avatar team-avatar-<?php echo (($i % 6) + 1); ?>" aria-hidden="true"><?php echo e($member['initials']); ?></div>
        <?php endif; ?>
        <div class="team-info">
          <span class="team-role"><?php echo e($member['role']); ?></span>
          <h3><?php echo e($member['name']); ?></h3>
          <?php if (!empty($member['bio'])): ?>
          <p><?php echo e($member['bio']); ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta cta-about">
  <div class="container">
    <h2 data-aos="zoom-in" data-aos-duration="1200">Ready to Experience Better Care?</h2>
    <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100">Our team is available 24/7. Book an appointment online or call our emergency line.</p>
    <a href="book-appointment.php" class="btn" style="background:#fff;color:var(--accent);" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">Book an Appointment</a>
  </div>
</section>
