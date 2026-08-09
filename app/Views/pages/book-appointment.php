<section class="page-banner">
  <div class="container">
    <h1>Book an Appointment</h1>
    <div class="breadcrumb"><a href="index.php">Home</a> / Book an Appointment</div>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:820px;">

    <?php if ($success): ?>
      <div class="form-box text-center">
        <div class="icon" style="margin:0 auto 20px;">✅</div>
        <h2>Appointment Request Received!</h2>
        <p style="color:var(--gray); margin:16px 0;">Thank you. Your appointment request has been submitted successfully. Your booking reference number is:</p>
        <h3 style="color:var(--primary); font-size:26px; margin-bottom:20px;"><?php echo e($booking_ref); ?></h3>
        <p style="color:var(--gray);">Our team will contact you shortly at the phone number/email provided to confirm your exact appointment slot.</p>
        <a href="book-appointment.php" class="btn btn-secondary mt-20">Book Another Appointment</a>
      </div>
    <?php else: ?>

    <div class="section-title" style="max-width:100%;">
      <span>4 Simple Steps</span>
      <h2>Schedule Your Visit</h2>
      <p>Select department, choose a doctor, pick your date & time, and fill in your details.</p>
    </div>

    <?php foreach ($errors as $err): ?>
      <div class="alert alert-error"><?php echo e($err); ?></div>
    <?php endforeach; ?>

    <div class="form-box">
      <form method="POST" action="book-appointment.php">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">

        <h3 class="mb-20">1. Select Department</h3>
        <div class="form-group">
          <label>Department *</label>
          <select name="department" id="departmentSelect" required>
            <option value="">Choose a Department</option>
            <?php foreach ($departments as $d): ?>
            <option value="<?php echo e($d['id']); ?>"><?php echo e($d['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <h3 class="mb-20 mt-20">2. Choose Doctor</h3>
        <div class="form-group">
          <label>Doctor *</label>
          <select name="doctor" required>
            <option value="">Choose a Doctor</option>
            <?php foreach ($doctors as $doc): ?>
            <option value="<?php echo e($doc['id']); ?>" <?php echo ($preselect_doctor == $doc['id']) ? 'selected' : ''; ?>>
              <?php echo e($doc['name']); ?> — <?php echo e($doc['department_name']); ?> (<?php echo e($doc['specialty']); ?>)
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <h3 class="mb-20 mt-20">3. Select Date & Time</h3>
        <div class="form-row">
          <div class="form-group">
            <label>Preferred Date *</label>
            <input type="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
          </div>
          <div class="form-group">
            <label>Preferred Time *</label>
            <select name="appointment_time" required>
              <option value="">Select Time Slot</option>
              <option>9:00 AM - 10:00 AM</option>
              <option>10:00 AM - 11:00 AM</option>
              <option>11:00 AM - 12:00 PM</option>
              <option>1:00 PM - 2:00 PM</option>
              <option>2:00 PM - 3:00 PM</option>
              <option>3:00 PM - 4:00 PM</option>
            </select>
          </div>
        </div>

        <h3 class="mb-20 mt-20">4. Patient Registration</h3>
        <div class="form-row">
          <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="patient_name" required>
          </div>
          <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" min="0" max="120">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Gender</label>
            <select name="gender">
              <option value="">Select</option>
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" name="phone" required>
          </div>
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email">
        </div>
        <div class="form-group">
          <label>Reason for Visit</label>
          <textarea name="reason" rows="3" placeholder="Briefly describe your symptoms or reason for the appointment"></textarea>
        </div>

        <button type="submit" name="book_submit" class="btn btn-primary">Confirm Appointment</button>
      </form>
    </div>
    <?php endif; ?>
  </div>
</section>