<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-col">
      <h3><?php echo SITE_NAME; ?></h3>
      <p><?php echo e(content('global', 'footer_text')); ?></p>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="<?php echo e(site_url('pages/about.php')); ?>">About Us</a></li>
        <li><a href="<?php echo e(site_url('pages/departments.php')); ?>">Departments</a></li>
        <li><a href="<?php echo e(site_url('pages/find-doctor.php')); ?>">Find a Doctor</a></li>
        <li><a href="<?php echo e(site_url('pages/careers.php')); ?>">Careers</a></li>
        <li><a href="<?php echo e(site_url('pages/contact.php')); ?>">Contact Us</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="<?php echo e(site_url('pages/services.php#emergency')); ?>">Emergency Services</a></li>
        <li><a href="<?php echo e(site_url('pages/services.php#opd')); ?>">Outpatient (OPD)</a></li>
        <li><a href="<?php echo e(site_url('pages/services.php#ipd')); ?>">Inpatient (IPD)</a></li>
        <li><a href="<?php echo e(site_url('pages/lab-report.php')); ?>">Lab Reports</a></li>
        <li><a href="<?php echo e(site_url('pages/international-patients.php')); ?>">International Patients</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact Info</h4>
      <ul class="contact-list">
        <li>📍 <?php echo e(content('global', 'address')); ?></li>
        <li>📞 <?php echo e(content('global', 'phone')); ?></li>
        <li>🚑 <?php echo e(content('global', 'emergency')); ?></li>
        <li>✉️ <?php echo e(content('global', 'email')); ?></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
    </div>
  </div>
</footer>
<script src="<?php echo e(site_url('js/script.js')); ?>"></script>
</body>
</html>
