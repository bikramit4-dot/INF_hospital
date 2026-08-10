<div class="admin-head">
  <div>
    <span class="kicker">Edit Pages</span>
    <h1><?php echo e($content_pages[$current]['label']); ?></h1>
    <p class="admin-head-note">Each section below is edited separately. Changes save straight to the database and appear on <a href="<?php echo e($content_pages[$current]['url']); ?>" target="_blank" rel="noopener">the live page</a>.</p>
  </div>
  <a class="btn btn-outline btn-sm" href="pages.php">&larr; All pages</a>
</div>

<?php echo $message; ?>

<div class="section-grid">
  <?php foreach ($page_data as $group_name => $fields): ?>
  <article class="section-card">
    <div class="section-card-head">
      <h3><?php echo e($group_name); ?></h3>
      <span class="count-chip"><?php echo count($fields); ?> field<?php echo count($fields) === 1 ? '' : 's'; ?></span>
    </div>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
      <input type="hidden" name="page" value="<?php echo e($current); ?>">
      <input type="hidden" name="group" value="<?php echo e($group_name); ?>">

      <div class="section-card-body">
        <div class="field-grid">
          <?php foreach ($fields as $f): ?>
          <?php $is_wide = $f['type'] === 'textarea'; ?>
          <div class="field-cell<?php echo $is_wide ? ' full' : ''; ?>">
            <div class="field-top">
              <label for="field_<?php echo e($f['section']); ?>"><?php echo e($f['label']); ?></label>
              <?php if (!$f['is_custom']): ?>
              <span class="badge badge-default" title="No custom value saved — showing the site default.">Default</span>
              <?php endif; ?>
            </div>
            <?php if ($is_wide): ?>
            <textarea id="field_<?php echo e($f['section']); ?>" name="c_<?php echo e($f['section']); ?>" rows="<?php echo $f['rows']; ?>"><?php echo e($f['value']); ?></textarea>
            <?php else: ?>
            <input type="text" id="field_<?php echo e($f['section']); ?>" name="c_<?php echo e($f['section']); ?>" value="<?php echo e($f['value']); ?>">
            <?php endif; ?>
            <?php if ($f['hint'] !== ''): ?><p class="form-hint"><?php echo e($f['hint']); ?></p><?php endif; ?>
            <div class="field-actions">
              <span class="field-blank-hint">Blank = site default</span>
              <button type="submit" name="reset_section" value="<?php echo e($f['section']); ?>" class="btn btn-xs btn-ghost js-reset-confirm" data-confirm="Reset “<?php echo e($f['label']); ?>” to its default value?">Reset to default</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="section-card-actions">
        <button type="submit" class="btn btn-primary btn-sm"><?php echo admin_icon('check'); ?> Save <?php echo e($group_name); ?></button>
        <span class="field-blank-hint">Saving applies these changes to the public website immediately.</span>
      </div>
    </form>
  </article>
  <?php endforeach; ?>
</div>
