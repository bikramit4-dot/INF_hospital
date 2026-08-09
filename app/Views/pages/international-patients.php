<section class="page-banner">
  <div class="container">
    <h1 data-aos="fade-up" data-aos-duration="1000">International Patients</h1>
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100"><a href="index.php">Home</a> / International Patients</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($blocks as $i => $b): ?>
    <div class="service-block" id="<?php echo e($b['id']); ?>" data-aos="<?php echo ($i % 2 === 0) ? 'fade-left' : 'fade-right'; ?>" data-aos-duration="1000">
      <div class="service-block-inner">
        <div class="service-icon"><?php echo $b['icon']; ?></div>
        <div>
          <h2><?php echo e($b['title']); ?></h2>
          <p style="color:var(--gray); margin-top:10px;"><?php echo e($b['desc']); ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 data-aos="zoom-in" data-aos-duration="1200">Planning to Travel for Treatment?</h2>
    <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100">Contact our international patient desk to start planning your visit.</p>
    <a href="contact.php" class="btn" style="background:#fff;color:var(--accent);" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">Contact Us</a>
  </div>
</section>
