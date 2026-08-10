<section class="page-banner">
  <div class="container">
    <h1 data-aos="fade-up" data-aos-duration="1000"><?php echo e(content('find-doctor', 'banner_title')); ?></h1>
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Find a Doctor</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="tabs" data-aos="fade-up" data-aos-duration="1000">
      <a href="<?php echo e(site_url('pages/find-doctor.php?by=name')); ?>" class="tab-btn <?php echo $by=='name'?'active':''; ?>">Search by Name</a>
      <a href="<?php echo e(site_url('pages/find-doctor.php?by=department')); ?>" class="tab-btn <?php echo $by=='department'?'active':''; ?>">Search by Department</a>
      <a href="<?php echo e(site_url('pages/find-doctor.php?by=specialty')); ?>" class="tab-btn <?php echo $by=='specialty'?'active':''; ?>">Search by Specialty</a>
    </div>

    <div class="form-box mb-20" data-aos="zoom-in" data-aos-duration="1200">
      <form method="GET" action="<?php echo e(site_url('pages/find-doctor.php')); ?>" class="form-row" style="align-items:end;">
        <input type="hidden" name="by" value="<?php echo e($by); ?>">
        <?php if ($by === 'department'): ?>
          <div class="form-group" style="grid-column: span 1;">
            <label>Select Department</label>
            <select name="dept">
              <option value="">All Departments</option>
              <?php foreach ($departments as $d): ?>
              <option value="<?php echo e($d['id']); ?>" <?php echo ($dept_filter == $d['id']) ? 'selected' : ''; ?>><?php echo e($d['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <?php else: ?>
          <div class="form-group">
            <label><?php echo $by === 'specialty' ? 'Specialty Keyword' : 'Doctor Name'; ?></label>
            <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="<?php echo $by === 'specialty' ? 'e.g. Cardiologist' : 'e.g. Dr. Sharma'; ?>">
          </div>
        <?php endif; ?>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" data-aos="zoom-in" data-aos-duration="1200">Search</button>
        </div>
      </form>
    </div>

    <div class="grid grid-4">
      <?php if (empty($results)): ?>
        <p style="grid-column:1/-1; color:var(--gray);">No doctors found matching your search. Try a different keyword.</p>
      <?php endif; ?>
      <?php foreach ($results as $i => $doc): ?>
      <div class="doctor-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?php echo ($i % 4) * 100; ?>">
        <?php if (!empty($doc['photo_url'])): ?>
        <div class="doctor-photo"><img src="<?php echo e($doc['photo_url']); ?>" alt="<?php echo e($doc['name']); ?>"></div>
        <?php else: ?>
        <div class="doctor-photo">👨‍⚕️</div>
        <?php endif; ?>
        <div class="doctor-info">
          <h3><?php echo e($doc['name']); ?></h3>
          <div class="dept"><?php echo e($doc['department_name']); ?></div>
          <p><?php echo e($doc['specialty']); ?></p>
          <p><?php echo e($doc['experience']); ?> experience</p>
          <p><?php echo e($doc['days']); ?>, <?php echo e($doc['time_slot']); ?></p>
          <a href="<?php echo e(site_url('pages/book-appointment.php?doctor=' . urlencode($doc['name']))); ?>" class="btn btn-secondary mt-20" data-aos="zoom-in" data-aos-duration="1200">Book Appointment</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
