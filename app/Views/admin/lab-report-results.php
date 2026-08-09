<div class="page-head">
  <div>
    <h1>Lab Report Results</h1>
    <p>Manage the individual test parameters for report <strong><?php echo e($report['report_id']); ?></strong>.</p>
  </div>
  <a href="lab-reports.php" class="btn btn-sm btn-outline-dark"><?php echo admin_icon('arrow'); ?> Back to Reports</a>
</div>

<div class="card info-card">
  <div class="info-grid">
    <div><span class="info-label">Patient</span><span class="info-value"><?php echo e($report['patient_name']); ?></span></div>
    <div><span class="info-label">Phone</span><span class="info-value"><?php echo e($report['patient_phone']); ?></span></div>
    <div><span class="info-label">Test</span><span class="info-value"><?php echo e($report['test_name']); ?></span></div>
    <div><span class="info-label">Date</span><span class="info-value"><?php echo e($report['report_date']); ?></span></div>
    <div>
      <span class="info-label">Status</span>
      <?php
      $status_key = strtolower((string) $report['status']);
      $status_badge = in_array($status_key, ['verified', 'confirmed'], true) ? 'confirmed' : ($status_key === 'rejected' ? 'cancelled' : 'pending');
      ?>
      <span class="badge badge-<?php echo e($status_badge); ?>"><?php echo e($report['status']); ?></span>
    </div>
  </div>
</div>

<?php echo $message; ?>

<div class="crud-grid">
  <!-- Add result -->
  <div class="card">
    <div class="card-head"><h3>Add Result</h3></div>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
      <input type="hidden" name="action" value="add">
      <div class="form-group">
        <label for="parameter_name">Parameter Name *</label>
        <input type="text" id="parameter_name" name="parameter_name" required placeholder="e.g. Hemoglobin">
      </div>
      <div class="form-group">
        <label for="result_value">Result Value *</label>
        <input type="text" id="result_value" name="result_value" required placeholder="e.g. 14.2 g/dL">
      </div>
      <div class="form-group">
        <label for="reference_range">Reference Range</label>
        <input type="text" id="reference_range" name="reference_range" placeholder="e.g. 13.5 - 17.5 g/dL">
      </div>
      <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order" value="0">
      </div>
      <div class="form-group form-check">
        <label class="check-label">
          <input type="checkbox" id="is_abnormal" name="is_abnormal" value="1">
          <span>Abnormal result</span>
        </label>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Add Result</button>
    </form>
  </div>

  <!-- Existing results -->
  <div class="card">
    <div class="card-head">
      <h3>Existing Results</h3>
      <span class="count-chip"><?php echo count($items); ?> parameter<?php echo count($items) === 1 ? '' : 's'; ?></span>
    </div>
    <?php if (empty($items)): ?>
      <div class="empty-state">
        <span class="empty-icon"><?php echo admin_icon('file'); ?></span>
        <p>No results yet.</p>
        <small>Add the first test parameter using the form.</small>
      </div>
    <?php else: ?>
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Parameter</th>
              <th>Result</th>
              <th>Reference Range</th>
              <th>Status</th>
              <th class="th-actions">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
              <td class="col-id">#<?php echo (int) $item['id']; ?></td>
              <td><?php echo e($item['parameter_name']); ?></td>
              <td><?php echo e($item['result_value']); ?></td>
              <td><?php echo e($item['reference_range']); ?></td>
              <td>
                <?php if ((int) $item['is_abnormal'] === 1): ?>
                  <span class="badge badge-cancelled">Abnormal</span>
                <?php else: ?>
                  <span class="badge badge-confirmed">Normal</span>
                <?php endif; ?>
              </td>
              <td class="td-actions">
                <form method="post" class="inline-form js-confirm" data-confirm="Delete this result parameter?">
                  <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                  <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
