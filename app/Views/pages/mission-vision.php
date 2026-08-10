<!-- Page banner -->
<section class="page-banner page-banner-image">
  <div class="container">
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="800"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / <?php echo e(content('mission-vision', 'banner_title')); ?></div>
    <h1 data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"><?php echo e(content('mission-vision', 'banner_title')); ?></h1>
    <p data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><?php echo e(content('mission-vision', 'banner_subtitle')); ?></p>
  </div>
</section>

<!-- Mission & Vision -->
<section class="section">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span><?php echo e(content('mission-vision', 'purpose_kicker')); ?></span>
      <h2><?php echo e(content('mission-vision', 'purpose_title')); ?></h2>
      <p><?php echo e(content('mission-vision', 'purpose_text')); ?></p>
    </div>
    <div class="grid grid-2">
      <div class="card mv-card" data-aos="fade-right" data-aos-duration="1000">
        <div class="mv-photo"><img src="<?php echo e(site_url('images/gettyimages-1390026192.jpg')); ?>" alt="Our doctors caring for a patient"></div>
        <div class="mv-body">
          <div class="icon">🎯</div>
          <h2><?php echo e(content('mission-vision', 'mission_title')); ?></h2>
          <p><?php echo e(content('mission-vision', 'mission_text')); ?></p>
          <ul class="mv-points">
            <?php foreach (content_lines('mission-vision', 'mission_points') as $point): ?>
            <li><?php echo e($point); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="card mv-card" data-aos="fade-left" data-aos-duration="1000">
        <div class="mv-photo"><img src="<?php echo e(site_url('images/about-care.jpg')); ?>" alt="A caring consultation at <?php echo e(SITE_NAME); ?>"></div>
        <div class="mv-body">
          <div class="icon">👁️</div>
          <h2><?php echo e(content('mission-vision', 'vision_title')); ?></h2>
          <p><?php echo e(content('mission-vision', 'vision_text')); ?></p>
          <ul class="mv-points">
            <?php foreach (content_lines('mission-vision', 'vision_points') as $point): ?>
            <li><?php echo e($point); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Core Values -->
<section class="section section-alt">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span><?php echo e(content('mission-vision', 'values_kicker')); ?></span>
      <h2><?php echo e(content('mission-vision', 'values_title')); ?></h2>
      <p><?php echo e(content('mission-vision', 'values_text')); ?></p>
    </div>
    <div class="grid grid-3">
      <div class="card" data-aos="fade-up" data-aos-duration="900">
        <div class="icon">🧑‍⚕️</div>
        <h3><?php echo e(content('mission-vision', 'value_1_title')); ?></h3>
        <p><?php echo e(content('mission-vision', 'value_1_desc')); ?></p>
      </div>
      <div class="card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="80">
        <div class="icon">🔬</div>
        <h3><?php echo e(content('mission-vision', 'value_2_title')); ?></h3>
        <p><?php echo e(content('mission-vision', 'value_2_desc')); ?></p>
      </div>
      <div class="card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="160">
        <div class="icon">🤝</div>
        <h3><?php echo e(content('mission-vision', 'value_3_title')); ?></h3>
        <p><?php echo e(content('mission-vision', 'value_3_desc')); ?></p>
      </div>
      <div class="card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="240">
        <div class="icon">💡</div>
        <h3><?php echo e(content('mission-vision', 'value_4_title')); ?></h3>
        <p><?php echo e(content('mission-vision', 'value_4_desc')); ?></p>
      </div>
      <div class="card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="320">
        <div class="icon">🌍</div>
        <h3><?php echo e(content('mission-vision', 'value_5_title')); ?></h3>
        <p><?php echo e(content('mission-vision', 'value_5_desc')); ?></p>
      </div>
      <div class="card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="400">
        <div class="icon">🤲</div>
        <h3><?php echo e(content('mission-vision', 'value_6_title')); ?></h3>
        <p><?php echo e(content('mission-vision', 'value_6_desc')); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta cta-about">
  <div class="container">
    <h2 data-aos="zoom-in" data-aos-duration="1200"><?php echo e(content('mission-vision', 'cta_title')); ?></h2>
    <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100"><?php echo e(content('mission-vision', 'cta_text')); ?></p>
    <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn" style="background:#fff;color:var(--accent);" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"><?php echo e(content('mission-vision', 'cta_btn')); ?></a>
  </div>
</section>
