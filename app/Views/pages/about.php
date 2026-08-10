<!-- Page banner -->
<section class="page-banner page-banner-image">
  <div class="container">
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="800"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / <?php echo e(content('about', 'banner_title')); ?></div>
    <h1 data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"><?php echo e(content('about', 'banner_title')); ?></h1>
    <p data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"><?php echo e(content('about', 'banner_subtitle')); ?></p>
  </div>
</section>

<!-- Who We Are -->
<section class="section">
  <div class="container about-intro-grid">
    <div class="about-media" data-aos="fade-right" data-aos-duration="1000">
      <img class="about-media-main" src="<?php echo e(site_url('images/about-care.jpg')); ?>" alt="A doctor and patient in a caring consultation at <?php echo e(SITE_NAME); ?>">
      <img class="about-media-secondary" src="<?php echo e(site_url('images/gettyimages-1390026192.jpg')); ?>" alt="Inside the hospital facility" loading="lazy">
      <div class="about-badge">
        <strong>25+</strong>
        <span>Years of<br>Excellence</span>
      </div>
    </div>

    <div class="about-copy" data-aos="fade-left" data-aos-duration="1000">
      <span class="section-kicker"><?php echo e(content('about', 'who_kicker')); ?></span>
      <h2><?php echo e(content('about', 'who_title')); ?></h2>
      <p><?php echo e(content('about', 'who_p1')); ?></p>
      <p><?php echo e(content('about', 'who_p2')); ?></p>
      <ul class="about-features">
        <li><span class="feature-check">✔</span> <?php echo e(content('about', 'who_feature_1')); ?></li>
        <li><span class="feature-check">✔</span> <?php echo e(content('about', 'who_feature_2')); ?></li>
        <li><span class="feature-check">✔</span> <?php echo e(content('about', 'who_feature_3')); ?></li>
      </ul>
      <div class="about-actions">
        <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn btn-secondary">Book an Appointment</a>
        <a href="<?php echo e(site_url('pages/contact.php')); ?>" class="btn btn-outline-dark">Contact Us</a>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section section-alt">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span><?php echo e(content('about', 'why_kicker')); ?></span>
      <h2><?php echo e(content('about', 'why_title')); ?></h2>
      <p><?php echo e(content('about', 'why_text')); ?></p>
    </div>
    <div class="grid grid-3">
      <div class="card feature-card" data-aos="fade-up" data-aos-duration="1000">
        <div class="icon">👨‍⚕️</div>
        <h3><?php echo e(content('about', 'why_1_title')); ?></h3>
        <p><?php echo e(content('about', 'why_1_desc')); ?></p>
      </div>
      <div class="card feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
        <div class="icon">🚑</div>
        <h3><?php echo e(content('about', 'why_2_title')); ?></h3>
        <p><?php echo e(content('about', 'why_2_desc')); ?></p>
      </div>
      <div class="card feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
        <div class="icon">🔬</div>
        <h3><?php echo e(content('about', 'why_3_title')); ?></h3>
        <p><?php echo e(content('about', 'why_3_desc')); ?></p>
      </div>
      <div class="card feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
        <div class="icon">🏥</div>
        <h3><?php echo e(content('about', 'why_4_title')); ?></h3>
        <p><?php echo e(content('about', 'why_4_desc')); ?></p>
      </div>
      <div class="card feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
        <div class="icon">🌍</div>
        <h3><?php echo e(content('about', 'why_5_title')); ?></h3>
        <p><?php echo e(content('about', 'why_5_desc')); ?></p>
      </div>
      <div class="card feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
        <div class="icon">❤️</div>
        <h3><?php echo e(content('about', 'why_6_title')); ?></h3>
        <p><?php echo e(content('about', 'why_6_desc')); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- Milestones timeline -->
<section class="section">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span>Our Journey</span>
      <h2>Hospital Milestones</h2>
      <p>A quarter century of growth, innovation, and service to our community.</p>
    </div>
    <div class="timeline">
      <div class="timeline-item" data-aos="fade-up" data-aos-duration="900">
        <span class="timeline-year">2000</span>
        <h3>A Humble Beginning</h3>
        <p>Founded as a small community clinic in Pokhara with a handful of dedicated staff.</p>
      </div>
      <div class="timeline-item" data-aos="fade-up" data-aos-duration="900">
        <span class="timeline-year">2008</span>
        <h3>Becoming a Hospital</h3>
        <p>Expanded into a 100-bed multi-specialty hospital serving the wider region.</p>
      </div>
      <div class="timeline-item" data-aos="fade-up" data-aos-duration="900">
        <span class="timeline-year">2016</span>
        <h3>Advanced Diagnostics</h3>
        <p>Launched our advanced diagnostic and imaging center with modern technology.</p>
      </div>
      <div class="timeline-item" data-aos="fade-up" data-aos-duration="900">
        <span class="timeline-year">2026</span>
        <h3>300+ Beds &amp; Growing</h3>
        <p>Now serving thousands of patients every year with 300+ beds and expert teams.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta cta-about">
  <div class="container">
    <h2 data-aos="zoom-in" data-aos-duration="1200"><?php echo e(content('about', 'cta_title')); ?></h2>
    <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100"><?php echo e(content('about', 'cta_text')); ?></p>
    <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn" style="background:#fff;color:var(--accent);" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"><?php echo e(content('about', 'cta_btn')); ?></a>
  </div>
</section>
