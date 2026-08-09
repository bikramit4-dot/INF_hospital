<section class="page-banner">
  <div class="container">
    <h1>News and Events</h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/pages/index.php'))); ?>">Home</a> / News and Events</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-title">
      <span>Stay Updated</span>
      <h2>Latest News & Upcoming Events</h2>
      <p>Hospital news, health campaigns, medical seminars, and community programs.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($news_events as $item): ?>
      <div class="news-card">
        <div class="news-body">
          <span class="news-category"><?php echo e($item['category']); ?></span>
          <h3><?php echo e($item['title']); ?></h3>
          <p class="news-date mt-20"><?php echo date('F j, Y', strtotime($item['event_date'])); ?></p>
          <p style="color:var(--gray); margin-top:8px;"><?php echo e($item['excerpt']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-title">
      <span>Explore</span>
      <h2>Browse by Category</h2>
    </div>
    <div class="grid grid-4">
      <div class="card text-center"><h3>📰</h3><p class="mt-20">Hospital News</p></div>
      <div class="card text-center"><h3>📅</h3><p class="mt-20">Upcoming Events</p></div>
      <div class="card text-center"><h3>🩺</h3><p class="mt-20">Health Campaigns</p></div>
      <div class="card text-center"><h3>🎓</h3><p class="mt-20">Medical Seminars</p></div>
      <div class="card text-center"><h3>🤝</h3><p class="mt-20">Community Programs</p></div>
      <div class="card text-center"><h3>📢</h3><p class="mt-20">Press Releases</p></div>
      <div class="card text-center"><h3>📚</h3><p class="mt-20">Health Articles</p></div>
    </div>
  </div>
</section>