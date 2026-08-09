<?php
$is_edit = !empty($edit_item);
$form_heading = $is_edit
    ? e($form_title_edit ?? 'Edit Record #' . (int) $edit_item['id'])
    : e($form_title);
$submit_label = $is_edit ? ($submit_edit_text ?? 'Update') : e($submit_text ?? 'Save');
$singular = $item_label ?? strtolower(rtrim($list_title, 's'));
?>
<div class="page-head">
  <div>
    <h1><?php echo e($heading); ?></h1>
    <p><?php echo e($subtitle ?? 'Add, edit, or remove the entries shown below.'); ?></p>
  </div>
  <?php if ($is_edit): ?>
  <a href="?" class="btn btn-sm btn-outline-dark"><?php echo admin_icon('plus'); ?> Cancel Edit</a>
  <?php endif; ?>
</div>

<?php echo $message; ?>

<div class="crud-grid">
  <!-- Add / edit form -->
  <div class="card">
    <div class="card-head">
      <h3><?php echo $form_heading; ?></h3>
      <?php if ($is_edit): ?><span class="badge badge-active">Editing #<?php echo (int) $edit_item['id']; ?></span><?php endif; ?>
    </div>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
      <input type="hidden" name="action" value="<?php echo $is_edit ? 'update' : 'create'; ?>">
      <?php if ($is_edit): ?>
      <input type="hidden" name="id" value="<?php echo (int) $edit_item['id']; ?>">
      <?php endif; ?>

      <?php foreach ($fields as $field):
          $fname = $field['name'];
          $fcol = $field['col'] ?? $fname;
          $fvalue = $is_edit ? ($edit_item[$fcol] ?? '') : ($field['default'] ?? '');
          $is_full = in_array($field['type'], ['textarea', 'checkbox'], true);
      ?>
      <?php if ($field['type'] === 'checkbox'): ?>
      <div class="form-group<?php echo $is_full ? ' full' : ''; ?>">
        <label class="check-label" for="field_<?php echo e($fname); ?>">
          <input type="checkbox" id="field_<?php echo e($fname); ?>" name="<?php echo e($fname); ?>" value="1" <?php echo !empty($fvalue) ? 'checked' : ''; ?>>
          <?php echo e($field['label']); ?>
        </label>
      </div>
      <?php else: ?>
      <div class="form-group<?php echo $is_full ? ' full' : ''; ?>">
        <label for="field_<?php echo e($fname); ?>"><?php echo e($field['label']); ?><?php if (empty($field['optional'])): ?> <span class="req">*</span><?php endif; ?></label>
        <?php if ($field['type'] === 'textarea'): ?>
          <textarea id="field_<?php echo e($fname); ?>" name="<?php echo e($fname); ?>" rows="<?php echo $field['rows'] ?? 4; ?>" <?php echo empty($field['optional']) ? 'required' : ''; ?>><?php echo e($fvalue); ?></textarea>
        <?php elseif ($field['type'] === 'select'): ?>
          <select id="field_<?php echo e($fname); ?>" name="<?php echo e($fname); ?>" <?php echo empty($field['optional']) ? 'required' : ''; ?>>
            <?php foreach ($field['options'] as $opt_val => $opt_label): ?>
            <option value="<?php echo e($opt_val); ?>" <?php echo (string) $fvalue === (string) $opt_val ? 'selected' : ''; ?>><?php echo e($opt_label); ?></option>
            <?php endforeach; ?>
          </select>
        <?php elseif ($field['type'] === 'file'): ?>
          <input type="file" id="field_<?php echo e($fname); ?>" name="<?php echo e($fname); ?>" accept="<?php echo e($field['accept'] ?? 'image/*'); ?>">
          <?php if (!empty($fvalue)): ?>
          <img class="file-preview" src="<?php echo e($fvalue); ?>" alt="Current <?php echo e($field['label']); ?> preview">
          <?php endif; ?>
        <?php else: ?>
          <input type="<?php echo e($field['type'] ?? 'text'); ?>" id="field_<?php echo e($fname); ?>" name="<?php echo e($fname); ?>" value="<?php echo e($fvalue); ?>" <?php echo empty($field['optional']) ? 'required' : ''; ?>>
        <?php endif; ?>
        <?php if (!empty($field['hint'])): ?><p class="form-hint"><?php echo e($field['hint']); ?></p><?php endif; ?>
      </div>
      <?php endif; ?>
      <?php endforeach; ?>

      <div class="form-submit">
        <button type="submit" class="btn btn-primary"><?php echo $submit_label; ?></button>
      </div>
    </form>
  </div>

  <!-- Existing records -->
  <div class="card">
    <div class="card-head">
      <h3><?php echo e($list_title); ?></h3>
      <span class="count-chip"><?php echo count($items); ?> record<?php echo count($items) === 1 ? '' : 's'; ?></span>
    </div>
    <?php if (empty($items)): ?>
      <div class="empty-state">
        <span class="empty-icon">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
        </span>
        <p>No items added yet.</p>
        <small>Use the form to add your first <?php echo e($singular); ?>.</small>
      </div>
    <?php else: ?>
      <div class="table-wrap">
        <table class="admin-table <?php echo e($table_class ?? ''); ?>">
          <thead>
            <tr>
              <th>#</th>
              <?php foreach ($columns as $col): ?>
              <th><?php echo e($col['label']); ?></th>
              <?php endforeach; ?>
              <th class="th-actions">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
            <tr class="<?php echo $is_edit && (int) $item['id'] === (int) $edit_item['id'] ? 'row-editing' : ''; ?>">
              <td class="col-id">#<?php echo (int) $item['id']; ?></td>
              <?php foreach ($columns as $col):
                  $val = $item[$col['key']] ?? '';
                  if (!empty($col['truncate']) && mb_strlen((string) $val) > (int) $col['truncate']):
                      $val = mb_strimwidth((string) $val, 0, (int) $col['truncate'], '…');
                  endif;
              ?>
              <?php if (!empty($col['type']) && $col['type'] === 'image'): ?>
              <td><?php if ($val): ?><img class="cell-thumb" src="<?php echo e(function_exists('site_url') ? site_url($val) : $val); ?>" alt=""><?php else: ?>—<?php endif; ?></td>
              <?php elseif (!empty($col['badge_map'])): ?>
              <td><span class="badge badge-<?php echo e($col['badge_map'][$val] ?? 'neutral'); ?>"><?php echo e($col['label_map'][$val] ?? $val); ?></span></td>
              <?php else: ?>
              <td class="<?php echo !empty($col['truncate']) ? 'cell-truncate' : ''; ?>"><?php echo e($val); ?></td>
              <?php endif; ?>
              <?php endforeach; ?>
              <td class="td-actions">
                <div class="action-btns">
                  <?php foreach (($row_links ?? []) as $link): ?>
                  <a class="btn btn-xs btn-ghost" href="<?php echo e(sprintf($link['href'], (int) $item['id'])); ?>"><?php echo e($link['label']); ?></a>
                  <?php endforeach; ?>
                  <a class="btn btn-xs btn-ghost" href="?edit=<?php echo (int) $item['id']; ?>"><?php echo admin_icon('edit'); ?> Edit</a>
                  <form method="post" class="inline-form js-confirm" data-confirm="Delete this record? This action cannot be undone.">
                    <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
