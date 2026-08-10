<section class="page-banner">
  <div class="container">
    <h1 data-aos="fade-up" data-aos-duration="1000"><?php echo e(content('lab-report', 'banner_title')); ?></h1>
    <div class="breadcrumb" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Lab Report</div>
  </div>
</section>

<section class="section" id="view">
  <div class="container" style="max-width:760px;">
    <div class="section-title" style="max-width:100%;" data-aos="fade-up" data-aos-duration="1000">
      <span><?php echo e(content('lab-report', 'report_kicker')); ?></span>
      <h2><?php echo e(content('lab-report', 'report_title')); ?></h2>
      <p><?php echo e(content('lab-report', 'report_text')); ?></p>
    </div>

    <div class="form-box mb-20" data-aos="zoom-in" data-aos-duration="1200">
      <?php if ($lookup_error): ?>
        <div class="alert alert-error"><?php echo e($lookup_error); ?></div>
      <?php endif; ?>
      <form method="POST" action="<?php echo e(site_url('pages/lab-report.php#view')); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
        <div class="form-row">
          <div class="form-group">
            <label>Report ID *</label>
            <input type="text" name="report_id" placeholder="e.g. HH-LAB-1001" required>
          </div>
          <div class="form-group">
            <label>Registered Phone Number *</label>
            <input type="text" name="phone" placeholder="e.g. 9800000001" required>
          </div>
        </div>
        <button type="submit" name="lookup_submit" class="btn btn-primary" data-aos="zoom-in" data-aos-duration="1200">View Report</button>
      </form>
      <p style="margin-top:14px; font-size:13px; color:var(--gray);">Try sample IDs: <strong>HH-LAB-1001</strong> (phone 9800000001) or <strong>HH-LAB-1002</strong> (phone 9800000002)</p>
    </div>

    <?php if ($lookup_result): ?>
    <div class="form-box" id="results" data-aos="fade-up" data-aos-duration="1000">
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <h3>Report: <?php echo e($lookup_result['report_id']); ?></h3>
        <span class="news-category">Status: <?php echo e($lookup_result['status']); ?></span>
      </div>
      <p style="color:var(--gray); margin:14px 0;">
        <strong>Patient:</strong> <?php echo e($lookup_result['patient_name']); ?><br>
        <strong>Test:</strong> <?php echo e($lookup_result['test_name']); ?><br>
        <strong>Report Date:</strong> <?php echo e($lookup_result['report_date']); ?>
      </p>
      <div class="table-scroll">
        <table id="diagnostic">
          <tr><th>Parameter</th><th>Result</th><th>Reference Range</th></tr>
          <?php foreach ($lookup_result['results'] as $r): ?>
          <tr>
            <td><?php echo e($r['parameter_name']); ?></td>
            <td><?php echo e($r['result_value']); ?></td>
            <td><?php echo e($r['reference_range']); ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <div class="mt-20" id="download">
        <button type="button" id="printReportBtn" class="btn btn-secondary" data-aos="zoom-in" data-aos-duration="1200">🖨️ Print / Download as PDF</button>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section-alt" id="history">
  <div class="container">
    <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
      <span>Records</span>
      <h2>Report History</h2>
      <p>Once logged in with your patient account, you can view all your past lab reports here.</p>
    </div>
    <div class="table-scroll">
      <table data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
        <tr><th>Report ID</th><th>Test</th><th>Date</th><th>Status</th></tr>
        <?php foreach ($recent_reports as $r): ?>
        <tr><td><?php echo e($r['report_id']); ?></td><td><?php echo e($r['test_name']); ?></td><td><?php echo e($r['report_date']); ?></td><td><?php echo e($r['status']); ?></td></tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</section>

<section class="section" id="verify">
  <div class="container" style="max-width:600px;">
    <div class="section-title" style="max-width:100%;" data-aos="fade-up" data-aos-duration="1000">
      <span>Authenticity Check</span>
      <h2>Online Report Verification</h2>
      <p>Verify the authenticity of a printed lab report using its unique Report ID.</p>
    </div>
    <div class="form-box" data-aos="zoom-in" data-aos-duration="1200">
      <form method="POST" action="<?php echo e(site_url('pages/lab-report.php#view')); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
        <div class="form-group">
          <label>Report ID</label>
          <input type="text" name="report_id" placeholder="e.g. HH-LAB-1001" required>
        </div>
        <div class="form-group">
          <label>Registered Phone Number</label>
          <input type="text" name="phone" placeholder="Enter registered phone" required>
        </div>
        <button type="submit" name="lookup_submit" class="btn btn-primary" data-aos="zoom-in" data-aos-duration="1200">Verify Report</button>
      </form>
    </div>
  </div>
</section>
