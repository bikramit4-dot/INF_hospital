<section class="page-banner">
  <div class="container">
    <h1><?php echo e(content('research-education', 'banner_title')); ?></h1>
    <div class="breadcrumb"><a href="<?php echo e(site_url('pages/index.php')); ?>">Home</a> / Research & Education</div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-2">
    <div>
      <h2><?php echo e(content('research-education', 're_research_title')); ?></h2>
      <p style="color:var(--gray); margin-top:16px;"><?php echo e(content('research-education', 're_research_text')); ?></p>
      <ul style="margin-top:16px; color:var(--gray);">
        <li style="margin-bottom:10px;">✔ Clinical trials and studies</li>
        <li style="margin-bottom:10px;">✔ Collaborations with universities</li>
        <li style="margin-bottom:10px;">✔ Published research papers</li>
        <li style="margin-bottom:10px;">✔ Ethics committee oversight</li>
      </ul>
    </div>
    <div>
      <h2><?php echo e(content('research-education', 're_education_title')); ?></h2>
      <p style="color:var(--gray); margin-top:16px;"><?php echo e(content('research-education', 're_education_text')); ?></p>
      <ul style="margin-top:16px; color:var(--gray);">
        <li style="margin-bottom:10px;">✔ Residency and fellowship programs</li>
        <li style="margin-bottom:10px;">✔ Nursing and allied health training</li>
        <li style="margin-bottom:10px;">✔ CME conferences and workshops</li>
        <li style="margin-bottom:10px;">✔ Community health education</li>
      </ul>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-title">
      <span><?php echo e(content('research-education', 're_kicker')); ?></span>
      <h2><?php echo e(content('research-education', 're_resources_title')); ?></h2>
    </div>
    <div class="grid grid-3">
      <div class="card"><h3>📚 Health Library</h3><p>Access our comprehensive health library with articles on diseases, treatments, and wellness.</p></div>
      <div class="card"><h3>🎓 Training Programs</h3><p>Information about our medical training programs and how to apply.</p></div>
      <div class="card"><h3>📊 Research Publications</h3><p>Browse our published research papers and clinical studies.</p></div>
    </div>
  </div>
</section>