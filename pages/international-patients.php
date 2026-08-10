<?php
require_once __DIR__ . '/../includes/config.php';

use App\Core\View;

$page_title = "International Patients";

$blocks = [
    ['id' => 'services', 'icon' => '🌍', 'title' => content('international-patients', 'ip_services_title'), 'desc' => content('international-patients', 'ip_services_desc')],
    ['id' => 'packages', 'icon' => '📦', 'title' => content('international-patients', 'ip_packages_title'), 'desc' => content('international-patients', 'ip_packages_desc')],
    ['id' => 'visa', 'icon' => '🛂', 'title' => content('international-patients', 'ip_visa_title'), 'desc' => content('international-patients', 'ip_visa_desc')],
    ['id' => 'travel', 'icon' => '✈️', 'title' => content('international-patients', 'ip_travel_title'), 'desc' => content('international-patients', 'ip_travel_desc')],
    ['id' => 'accommodation', 'icon' => '🏨', 'title' => content('international-patients', 'ip_accommodation_title'), 'desc' => content('international-patients', 'ip_accommodation_desc')],
    ['id' => 'interpreter', 'icon' => '🗣️', 'title' => content('international-patients', 'ip_interpreter_title'), 'desc' => content('international-patients', 'ip_interpreter_desc')],
    ['id' => 'insurance', 'icon' => '📄', 'title' => content('international-patients', 'ip_insurance_title'), 'desc' => content('international-patients', 'ip_insurance_desc')],
];

View::render('pages/international-patients', compact('page_title', 'blocks', 'nav_menu'));