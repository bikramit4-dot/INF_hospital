<section class="page-banner">
  <div class="container">
    <h1><?php echo e(content('online-consultation', 'banner_title')); ?></h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / <?php echo e(content('online-consultation', 'banner_title')); ?></div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-2">
    <div>
      <h2><?php echo e(content('online-consultation', 'oc_title')); ?></h2>
      <p style="color:var(--gray); margin:16px 0;"><?php echo e(content('online-consultation', 'oc_text')); ?></p>
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
      <form method="POST" action="<?php echo e(site_url('pages/online-consultation.php')); ?>">
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