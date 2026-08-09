<div class="page-head">
  <div>
    <h1><?php echo e($heading); ?></h1>
    <p><?php echo e($subtitle ?? ''); ?></p>
  </div>
  <?php if (!empty($searchable)): ?>
  <form method="get" class="record-search" role="search">
    <input type="search" name="q" value="<?php echo e($q ?? ''); ?>" placeholder="<?php echo e($search_placeholder ?? 'Search records…'); ?>" aria-label="Search records">
    <button type="submit" class="btn btn-sm btn-primary"><?php echo admin_icon('search'); ?> Search</button>
    <input type="hidden" name="page" value="1">
    <?php if (!empty($q)): ?><a href="?" class="btn btn-sm btn-ghost">Clear</a><?php endif; ?>
  </form>
  <?php endif; ?>
</div>

<?php echo $message; ?>

<div class="card">
  <div class="card-head">
    <h3><?php echo e($list_title ?? $heading); ?></h3>
    <span class="count-chip"><?php echo count($items); ?> total</span>
  </div>

  <?php if (empty($items)): ?>
    <div class="empty-state">
      <span class="empty-icon"><?php echo admin_icon($empty_icon ?? 'inbox'); ?></span>
      <p><?php echo e($empty_text ?? 'No records yet.'); ?></p>
      <small>New submissions will appear here automatically.</small>
    </div>
  <?php else: ?>
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>#</th>
            <?php foreach ($columns as $col): ?>
            <th><?php echo e($col['label']); ?></th>
            <?php endforeach; ?>
            <?php if (!empty($actions) || !empty($allow_delete)): ?>
            <th class="th-actions">Actions</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
          <tr>
            <td class="col-id">#<?php echo (int) $item['id']; ?></td>
            <?php foreach ($columns as $col):
                $val = $item[$col['key']] ?? '';
                if (!empty($col['truncate']) && mb_strlen((string) $val) > (int) $col['truncate']):
                    $val = mb_strimwidth((string) $val, 0, (int) $col['truncate'], '…');
                endif;
                if (($badge_field ?? null) === $col['key']):
                    $badge_key = $badge_map[$val] ?? $val;
            ?>
            <td><span class="badge badge-<?php echo e($badge_key); ?>"><?php echo e(ucfirst($badge_key)); ?></span></td>
            <?php else: ?>
            <td class="<?php echo !empty($col['truncate']) ? 'cell-truncate' : ''; ?>"><?php echo e($val); ?></td>
            <?php endif;
            endforeach; ?>
            <?php if (!empty($actions) || !empty($allow_delete)): ?>
            <td class="td-actions">
              <div class="action-btns">
                <?php foreach ($actions ?? [] as $action): ?>
                  <?php if (in_array($item['status'] ?? $item['is_read'] ?? '', $action['hide_when'] ?? [], true)) continue; ?>
                  <form method="post" class="inline-form js-confirm" data-confirm="<?php echo e($action['confirm'] ?? 'Are you sure?'); ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                    <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                    <input type="hidden" name="action" value="<?php echo e($action['value']); ?>">
                    <button type="submit" class="btn btn-xs <?php echo e($action['class'] ?? 'btn-ghost'); ?>"><?php echo e($action['label']); ?></button>
                  </form>
                <?php endforeach; ?>
                <?php if (!empty($allow_delete)): ?>
                  <form method="post" class="inline-form js-confirm" data-confirm="Delete this record permanently? This cannot be undone.">
                    <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                    <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
            <?php endif; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <?php if (!empty($pagination) && $pagination['lastPage'] > 1): ?>
  <div class="pagination-bar">
    <span class="pagination-info">Page <?php echo $pagination['page']; ?> of <?php echo $pagination['lastPage']; ?> · <?php echo $pagination['total']; ?> total records</span>
    <div class="pagination-links">
      <?php
      $page_links = [];
      $query_params = $_GET;
      $perPage = $pagination['perPage'];

      $build_url = function ($page) use ($query_params) {
          $query_params['page'] = $page;
          return '?' . http_build_query($query_params);
      };

      if ($pagination['page'] > 1) {
          $page_links[] = '<a class="page-link page-prev" href="' . e($build_url($pagination['page'] - 1)) . '">‹ Prev</a>';
      }

      $range = 2; // pages before/after current
      $start = max(1, $pagination['page'] - $range);
      $end = min($pagination['lastPage'], $pagination['page'] + $range);

      if ($start > 1) {
          $page_links[] = '<a class="page-link" href="' . e($build_url(1)) . '">1</a>';
          if ($start > 2) {
              $page_links[] = '<span class="page-ellipsis">…</span>';
          }
      }

      for ($i = $start; $i <= $end; $i++) {
          $active = $i === $pagination['page'] ? ' class="page-link active"' : ' class="page-link"';
          $page_links[] = '<a' . $active . ' href="' . e($build_url($i)) . '">' . $i . '</a>';
      }

      if ($end < $pagination['lastPage']) {
          if ($end < $pagination['lastPage'] - 1) {
              $page_links[] = '<span class="page-ellipsis">…</span>';
          }
          $page_links[] = '<a class="page-link" href="' . e($build_url($pagination['lastPage'])) . '">' . $pagination['lastPage'] . '</a>';
      }

      if ($pagination['page'] < $pagination['lastPage']) {
          $page_links[] = '<a class="page-link page-next" href="' . e($build_url($pagination['page'] + 1)) . '">Next ›</a>';
      }

      echo implode('', $page_links);
      ?>
    </div>
  </div>
  <?php endif; ?>
</div>
