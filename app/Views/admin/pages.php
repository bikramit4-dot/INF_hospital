<div class="page-head">
  <div>
    <h1>Edit Pages</h1>
    <p>Manage the text content of every public page. Changes go live on the website instantly.</p>
  </div>
  <a href="../index.php" class="btn btn-sm btn-outline-dark" target="_blank" rel="noopener">View Website</a>
</div>

<?php echo $message; ?>

<!-- Page picker -->
<div class="page-picker" role="tablist" aria-label="Choose a page to edit">
  <?php foreach ($content_pages as $key => $pg): ?>
  <a class="page-pill<?php echo $key === $current ? ' active' : ''; ?>" href="?page=<?php echo e($key); ?>" role="tab" aria-selected="<?php echo $key === $current ? 'true' : 'false'; ?>">
    <span class="page-pill-icon"><?php echo e($pg['icon']); ?></span>
    <span><?php echo e($pg['label']); ?></span>
  </a>
  <?php endforeach; ?>
</div>

<!-- Editor -->
<div class="pages-editor">
  <div class="editor-intro">
    <div>
      <span class="editor-emoji"><?php echo e($content_pages[$current]['icon']); ?></span>
      <div>
        <h2><?php echo e($content_pages[$current]['label']); ?></h2>
        <p><?php echo $field_count; ?> editable field<?php echo $field_count === 1 ? '' : 's'; ?> · fields showing <span class="badge badge-active">Default</span> have not been customized yet.</p>
      </div>
    </div>
    <a href="<?php echo e($content_pages[$current]['url']); ?>" class="btn btn-sm btn-ghost" target="_blank" rel="noopener"><?php echo admin_icon('external'); ?> View this page</a>
  </div>

  <form method="post" class="pages-form">
    <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
    <input type="hidden" name="page" value="<?php echo e($current); ?>">

    <?php foreach ($page_data as $group_name => $fields): ?>
    <div class="card page-group">
      <div class="card-head">
        <h3><?php echo e($group_name); ?></h3>
        <span class="count-chip"><?php echo count($fields); ?> field<?php echo count($fields) === 1 ? '' : 's'; ?></span>
      </div>
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
            <button type="submit" name="reset_section" value="<?php echo e($f['section']); ?>" class="btn btn-xs btn-ghost js-reset-confirm" data-confirm="Reset “<?php echo e($f['label']); ?>” to its default value?">Reset to default</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="form-submit form-submit-sticky">
      <button type="submit" class="btn btn-primary"><?php echo admin_icon('plus'); ?> Save <?php echo e($content_pages[$current]['label']); ?></button>
      <span class="form-submit-note">Saving applies these changes to the public website immediately.</span>
    </div>
  </form>
</div>
