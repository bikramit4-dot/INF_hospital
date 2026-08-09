<section class="hero">
  <video class="hero-video" autoplay muted loop playsinline preload="auto"
    poster="<?php echo e(site_url('images/gettyimages-1390026192.jpg')); ?>" aria-hidden="true">
    <source src="<?php echo e(site_url('images/hero-background.mp4')); ?>" type="video/mp4">
  </video>
  <div class="hero-overlay" aria-hidden="true"></div>
  <div class="container hero-inner">
    <h1 data-aos="fade-up" data-aos-duration="1000">
      <span class="hero-title">Welcome to International Nepal Fellowship (Nepal)</span>
      
    </h1>
    <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">Home Hospital is committed to providing world-class healthcare with modern technology, expert specialists and patient-centered service, 24 hours a day.</p>
    <div class="hero-buttons">
      <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn btn-primary" data-aos="zoom-in" data-aos-duration="1200">Book Appointment</a>
      <a href="<?php echo e(site_url('pages/services.php#emergency')); ?>" class="btn btn-outline" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100">Emergency Services</a>
    </div>
  </div>
</section>

<section class="stats">
  <div class="container grid grid-4">
    <div data-aos="fade-up" data-aos-duration="1000"><h3>25+</h3><span>Years of Service</span></div>
    <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100"><h3>150+</h3><span>Expert Doctors</span></div>
    <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"><h3>300+</h3><span>Hospital Beds</span></div>
    <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300"><h3>24/7</h3><span>Emergency Care</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span>What We Offer</span>
      <h2>Our Core Services</h2>
      <p>From emergency care to specialized treatment, we offer a full spectrum of medical services under one roof.</p>
    </div>
    <?php if (!empty($services)): ?>
    <div class="services-carousel" data-carousel>
      <button class="carousel-btn carousel-btn-prev" type="button" data-carousel-prev aria-label="Previous services">&#8249;</button>
      <div class="carousel-viewport">
        <div class="carousel-track" data-carousel-track>
          <?php foreach ($services as $s): ?>
          <div class="carousel-slide">
            <div class="card service-card">
              <div class="service-img">
                <?php if (!empty($s['image_url'])): ?>
                <img src="<?php echo e(site_url($s['image_url'])); ?>" alt="<?php echo e($s['title']); ?>" loading="lazy">
                <?php else: ?>
                <span class="service-emoji"><?php echo e($s['icon']); ?></span>
                <?php endif; ?>
              </div>
              <div class="service-card-body">
                <h3><?php echo e($s['title']); ?></h3>
                <p><?php echo e($s['description']); ?></p>
                <a class="view-more" href="<?php echo e(site_url('pages/services.php#' . $s['slug'])); ?>">View More <span class="vm-arrow">&rarr;</span></a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <button class="carousel-btn carousel-btn-next" type="button" data-carousel-next aria-label="Next services">&#8250;</button>
    </div>
    <?php endif; ?>
    <p class="text-center mt-20"><a href="<?php echo e(site_url('pages/services.php')); ?>" class="btn btn-secondary btn-view-all" data-aos="zoom-in" data-aos-duration="1200">View All Services</a></p>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span>Our Specialists</span>
      <h2>Meet Our Doctors</h2>
      <p>Experienced, board-certified specialists dedicated to your health and wellbeing.</p>
    </div>
    <?php if (!empty($doctors)): ?>
    <div class="doctors-carousel" data-carousel>
      <button class="carousel-btn carousel-btn-prev" type="button" data-carousel-prev aria-label="Previous doctors">&#8249;</button>
      <div class="carousel-viewport">
        <div class="carousel-track" data-carousel-track>
          <?php foreach ($doctors as $doc): ?>
          <div class="carousel-slide">
            <div class="card doctor-card">
              <?php if (!empty($doc['photo_url'])): ?>
              <div class="doctor-photo"><img src="<?php echo e(site_url($doc['photo_url'])); ?>" alt="<?php echo e($doc['name']); ?>" loading="lazy"></div>
              <?php else: ?>
              <div class="doctor-photo doctor-photo-fallback"><span class="doctor-emoji">👨‍⚕️</span></div>
              <?php endif; ?>
              <div class="doctor-info">
                <h3><?php echo e($doc['name']); ?></h3>
                <div class="dept"><?php echo e($doc['department_name']); ?></div>
                <p><?php echo e($doc['specialty']); ?></p>
                <p><?php echo e($doc['experience']); ?> experience</p>
                <a class="view-more" href="<?php echo e(site_url('pages/book-appointment.php?doctor=' . (int)$doc['id'])); ?>">Book Appointment <span class="vm-arrow">&rarr;</span></a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <button class="carousel-btn carousel-btn-next" type="button" data-carousel-next aria-label="Next doctors">&#8250;</button>
    </div>
    <?php endif; ?>
    <p class="text-center mt-20"><a href="<?php echo e(site_url('pages/find-doctor.php')); ?>" class="btn btn-secondary" data-aos="zoom-in" data-aos-duration="1200">Find a Doctor</a></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span>Health Packages</span>
      <h2>Preventive Health Checkups</h2>
      <p>Affordable health packages designed for early detection and prevention.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach (array_slice($health_packages, 0, 3) as $i => $pkg): ?>
      <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?php echo $i * 100; ?>">
        <h3><?php echo e($pkg['name']); ?></h3>
        <p class="mb-20"><?php echo e($pkg['includes_text']); ?></p>
        <strong style="color:var(--primary); font-size:18px;"><?php echo e($pkg['price']); ?></strong>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="text-center mt-20"><a href="<?php echo e(site_url('pages/health-packages.php')); ?>" class="btn btn-secondary" data-aos="zoom-in" data-aos-duration="1200">View All Packages</a></p>
  </div>
</section>

<section class="cta">
  <div class="container">
    <h2 data-aos="zoom-in" data-aos-duration="1200">Need Medical Assistance?</h2>
    <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100">Our team is available 24/7. Book an appointment online or call our emergency line.</p>
    <a href="<?php echo e(site_url('pages/book-appointment.php')); ?>" class="btn" style="background:#fff;color:var(--accent);" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">Book an Appointment</a>
  </div>
</section>
