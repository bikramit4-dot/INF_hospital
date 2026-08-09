<section class="page-banner">
  <div class="container">
    <h1>Contact Us</h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Contact Us</div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-2">
    <div>
      <h2>Get in Touch</h2>
      <p style="color:var(--gray); margin:16px 0 24px;">Have a question or need assistance? Reach out to us using the form, or contact us directly using the information below.</p>
      <div class="card mb-20">
        <p>📍 <strong>Address:</strong> <?php echo SITE_ADDRESS; ?></p>
      </div>
      <div class="card mb-20">
        <p>📞 <strong>Phone:</strong> <?php echo SITE_PHONE; ?></p>
      </div>
      <div class="card mb-20">
        <p>🚑 <strong>Emergency:</strong> <?php echo SITE_EMERGENCY; ?></p>
      </div>
      <div class="card">
        <p>✉️ <strong>Email:</strong> <?php echo SITE_EMAIL; ?></p>
      </div>
    </div>
    <div class="form-box">
      <?php if ($success): ?>
        <div class="alert alert-success">Thank you for reaching out! We'll get back to you shortly.</div>
      <?php endif; ?>
      <?php foreach ($errors as $err): ?>
        <div class="alert alert-error"><?php echo e($err); ?></div>
      <?php endforeach; ?>
      <form method="POST" action="<?php echo e(site_url('pages/contact.php')); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="name" required>
        </div>
        <div class="form-group">
          <label>Email Address *</label>
          <input type="email" name="email" required>
        </div>
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject">
        </div>
        <div class="form-group">
          <label>Message *</label>
          <textarea name="message" rows="5" required></textarea>
        </div>
        <button type="submit" name="contact_submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-title">
      <span>Find Us</span>
      <h2>Our Location</h2>
    </div>
    <div style="border-radius:var(--radius); overflow:hidden; box-shadow:var(--shadow);">
      <iframe src="https://www.google.com/maps?q=Pokhara,Nepal&output=embed" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>