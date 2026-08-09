<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

use App\Core\View;
use App\Models\Appointment;
use App\Models\Contact;
use App\Models\OnlineConsultation;
use App\Models\CareerApplication;

$page_title = 'Admin Dashboard';
$pdo = get_db();

$stats = [
    'departments' => $pdo->query('SELECT COUNT(*) FROM departments')->fetchColumn(),
    'doctors' => $pdo->query('SELECT COUNT(*) FROM doctors')->fetchColumn(),
    'services' => $pdo->query('SELECT COUNT(*) FROM services')->fetchColumn(),
    'packages' => $pdo->query('SELECT COUNT(*) FROM health_packages')->fetchColumn(),
    'team' => $pdo->query('SELECT COUNT(*) FROM team_members')->fetchColumn(),
    'news' => $pdo->query('SELECT COUNT(*) FROM news_events')->fetchColumn(),
    'lab_reports' => $pdo->query('SELECT COUNT(*) FROM lab_reports')->fetchColumn(),
    'appointments' => Appointment::count('status = :status', [':status' => 'pending']),
    'contacts' => Contact::unreadCount(),
    'consultations' => OnlineConsultation::pendingCount(),
    'applications' => CareerApplication::pendingCount(),
];

$recent_appointments = array_slice(Appointment::allWithRelations([], 'a.created_at DESC'), 0, 5);
$recent_messages = array_slice(Contact::all('created_at DESC'), 0, 5);

View::renderAdmin('admin/dashboard', compact('page_title', 'stats', 'recent_appointments', 'recent_messages'));