<div class="page-head">
  <div>
    <h1>Change Password</h1>
    <p>Update your administrator password to keep the panel secure.</p>
  </div>
</div>

<?php if ($forced): ?>
  <div class="alert alert-error">Security: the default administrator password is still in use. Please set a new password now.</div>
<?php elseif ($needs_change): ?>
  <div class="alert alert-error">Security: the default administrator password is still in use. Please set a new password now.</div>
<?php endif; ?>

<?php echo $message; ?>

<div class="card narrow-card">
  <div class="card-head"><h3>Set New Password</h3></div>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
    <div class="form-group">
      <label for="current_password">Current Password</label>
      <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
    </div>
    <div class="form-group">
      <label for="new_password">New Password</label>
      <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
      <p class="form-hint">At least 10 characters, with uppercase, lowercase and a number.</p>
    </div>
    <div class="form-group">
      <label for="confirm_password">Confirm New Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Update Password</button>
  </form>
</div>
