<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-col">
      <a href="<?php echo e(site_url('index.php')); ?>" class="footer-logo-link" aria-label="<?php echo e(SITE_NAME); ?>">
        <img src="<?php echo e(site_url('images/logo-white.png')); ?>" alt="<?php echo e(SITE_NAME); ?>" class="footer-logo">
      </a>
      <p><?php echo SITE_TAGLINE; ?>. Providing quality, compassionate healthcare to our community with modern medical technology and dedicated specialists.</p>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="<?php echo e(site_url('about.php')); ?>">About Us</a></li>
        <li><a href="<?php echo e(site_url('departments.php')); ?>">Departments</a></li>
        <li><a href="<?php echo e(site_url('find-doctor.php')); ?>">Find a Doctor</a></li>
        <li><a href="<?php echo e(site_url('careers.php')); ?>">Careers</a></li>
        <li><a href="<?php echo e(site_url('contact.php')); ?>">Contact Us</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="<?php echo e(site_url('services.php#emergency')); ?>">Emergency Services</a></li>
        <li><a href="<?php echo e(site_url('services.php#opd')); ?>">Outpatient (OPD)</a></li>
        <li><a href="<?php echo e(site_url('services.php#ipd')); ?>">Inpatient (IPD)</a></li>
        <li><a href="<?php echo e(site_url('lab-report.php')); ?>">Lab Reports</a></li>
        <li><a href="<?php echo e(site_url('international-patients.php')); ?>">International Patients</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact Info</h4>
      <ul class="contact-list">
        <li>📍 <?php echo SITE_ADDRESS; ?></li>
        <li>📞 <?php echo SITE_PHONE; ?></li>
        <li>🚑 <?php echo SITE_EMERGENCY; ?></li>
        <li>✉️ <?php echo SITE_EMAIL; ?></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
    </div>
  </div>
</footer>
<script src="<?php echo e(site_url('js/aos.js')); ?>"></script>
<script src="<?php echo e(site_url('js/script.js?v=6')); ?>"></script>
</body>
</html>