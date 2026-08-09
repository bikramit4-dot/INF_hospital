<section class="page-banner">
  <div class="container">
    <h1>Online Consultation</h1>
    <div class="breadcrumb"><a href="index.php">Home</a> / Online Consultation</div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-2">
    <div>
      <h2>Consult a Doctor Online</h2>
      <p style="color:var(--gray); margin:16px 0;">Can't visit us in person? Request a video or phone consultation with one of our specialists from the comfort of your home. Fill out the form and our team will confirm your appointment time.</p>
      <ul style="color:var(--gray);">
        <li style="margin-bottom:10px;">✔ Secure video consultation</li>
        <li style="margin-bottom:10px;">✔ Prescription sent digitally</li>
        <li style="margin-bottom:10px;">✔ Follow-up support included</li>
      </ul>
    </div>
    <div class="form-box">
      <?php if ($success): ?>
        <div class="alert alert-success">Your consultation request has been received. We will contact you shortly to confirm your appointment.</div>
      <?php endif; ?>
      <?php foreach ($errors as $err): ?>
        <div class="alert alert-error"><?php echo e($err); ?></div>
      <?php endforeach; ?>
      <form method="POST" action="online-consultation.php">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="name" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" required>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone">
          </div>
        </div>
        <div class="form-group">
          <label>Department *</label>
          <select name="department" required>
            <option value="">Select Department</option>
            <?php foreach ($departments as $d): ?>
            <option value="<?php echo e($d['id']); ?>"><?php echo e($d['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Describe Your Issue *</label>
          <textarea name="issue" rows="4" required></textarea>
        </div>
        <button type="submit" name="consult_submit" class="btn btn-primary">Request Consultation</button>
      </form>
    </div>
  </div>
</section>