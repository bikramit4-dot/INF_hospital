<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;
use App\Models\TeamMember;

$page_title = "Management Team";
$team = TeamMember::allActive();
// Pre-compute initials for the avatar fallback (shown until a photo is uploaded)
foreach ($team as &$m) {
    $clean = preg_replace('/^(mr|mrs|ms|dr|prof|miss)\.?\s+/i', '', trim($m['name'] ?? ''));
    $words = preg_split('/\s+/', $clean);
    $m['initials'] = strtoupper(mb_substr($words[0] ?? '', 0, 1) . mb_substr($words[1] ?? '', 0, 1));
}
unset($m);
View::render('pages/management-team', compact('page_title', 'team', 'nav_menu'));