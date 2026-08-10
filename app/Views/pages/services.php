<section class="page-banner">
  <div class="container">
    <h1 data-aos="fade-up" data-aos-duration="1000"><?php echo e(content('services', 'banner_title')); ?></h1>
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Our Services</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($services as $i => $s): ?>
    <div class="service-block" id="<?php echo e($s['slug']); ?>" data-aos="<?php echo ($i % 2 === 0) ? 'fade-left' : 'fade-right'; ?>" data-aos-duration="1000">
      <div class="service-block-inner">
        <div class="service-icon"><?php echo $s['icon']; ?></div>
        <div>
          <h2><?php echo e($s['title']); ?></h2>
          <p style="color:var(--gray); margin-top:10px;"><?php echo e($s['description']); ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 data-aos="zoom-in" data-aos-duration="1200"><?php echo e(content('services', 'cta_title')); ?></h2>
    <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100"><?php echo e(content('services', 'cta_text')); ?></p>
    <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn" style="background:#fff;color:var(--accent);" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"><?php echo e(content('services', 'cta_btn')); ?></a>
  </div>
</section>
