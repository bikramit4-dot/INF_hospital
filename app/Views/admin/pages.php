<div class="admin-head">
  <div>
    <span class="kicker">Admin Panel</span>
    <h1>Edit Pages</h1>
    <p class="admin-head-note">Every public page is listed here with its sections separated. Open a page, then edit each section individually — headings, text, buttons and more.</p>
  </div>
  <a class="btn btn-outline btn-sm" href="../index.php" target="_blank" rel="noopener">View Site</a>
</div>

<?php echo $message; ?>

<div class="content-grid">
  <?php foreach ($page_cards as $card): ?>
  <a class="content-card" href="?page=<?php echo e($card['key']); ?>">
    <span class="content-card-icon"><?php echo e($card['icon']); ?></span>
    <div>
      <h3><?php echo e($card['label']); ?></h3>
      <p><?php echo (int) $card['field_count']; ?> editable field<?php echo (int) $card['field_count'] === 1 ? '' : 's'; ?></p>
    </div>
    <span class="content-card-arrow"><?php echo admin_icon('chevron-right'); ?></span>
  </a>
  <?php endforeach; ?>
</div>
