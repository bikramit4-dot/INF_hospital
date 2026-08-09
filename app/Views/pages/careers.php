<section class="page-banner">
  <div class="container">
    <h1>Careers</h1>
    <div class="breadcrumb"><a href="index.php">Home</a> / Careers</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span>Join Our Team</span>
      <h2>Current Openings</h2>
      <p>Build a rewarding career with us. Explore our current job openings below.</p>
    </div>
    <div class="table-scroll">
      <table>
        <tr><th>Position</th><th>Department</th><th>Type</th><th></th></tr>
        <?php foreach ($openings as $job): ?>
        <tr>
          <td><?php echo e($job['title']); ?></td>
          <td><?php echo e($job['dept']); ?></td>
          <td><?php echo e($job['type']); ?></td>
          <td><a href="#apply" style="color:var(--primary); font-weight:600;">Apply</a></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</section>

<section class="section section-alt" id="apply">
  <div class="container" style="max-width:700px;">
    <div class="section-title">
      <span>Application Form</span>
      <h2>Apply Now</h2>
    </div>
    <div class="form-box">
      <?php if ($success): ?>
        <div class="alert alert-success">Thank you! Your application has been submitted. Our HR team will contact you soon.</div>
      <?php endif; ?>
      <?php foreach ($errors as $err): ?>
        <div class="alert alert-error"><?php echo e($err); ?></div>
      <?php endforeach; ?>
      <form method="POST" action="careers.php#apply" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
        <div class="form-row">
          <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="full_name" required>
          </div>
          <div class="form-group">
            <label>Email Address *</label>
            <input type="email" name="email" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone">
          </div>
          <div class="form-group">
            <label>Position Applying For *</label>
            <select name="position" required>
              <option value="">Select Position</option>
              <?php foreach ($openings as $job): ?>
              <option value="<?php echo e($job['title']); ?>"><?php echo e($job['title']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Upload CV / Resume</label>
          <input type="file" name="cv">
        </div>
        <div class="form-group">
          <label>Cover Letter</label>
          <textarea name="cover_letter" rows="4"></textarea>
        </div>
        <button type="submit" name="apply_submit" class="btn btn-primary">Submit Application</button>
      </form>
    </div>
  </div>
</section>