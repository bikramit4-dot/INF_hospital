<?php
/**
 * Editable page content registry.
 *
 * This is the single source of truth for the text shown on each public
 * page. The admin panel (admin/pages.php) lets the site owner edit these
 * sections; the public pages read them through the content() helper
 * (includes/config.php) which falls back to these defaults.
 *
 * Structure:
 *   page key => [
 *     'label'  => name shown in the admin page picker,
 *     'icon'   => emoji shown in the admin page picker,
 *     'url'    => public URL of the page (relative to /admin/), for "view page",
 *     'groups' => [ group title => [ fields ] ],
 *   ]
 *
 * Each field:
 *   section => key stored in page_content,
 *   label   => form label,
 *   type    => 'text' | 'textarea',
 *   rows    => textarea rows (optional),
 *   hint    => helper text under the field (optional),
 *   default => fallback text used until the admin overrides it.
 *
 * @return array{pages: array, defaults: array<string,string>}
 */
$__pages = [

    // ----------------------------------------------------------------
    'home' => [
        'label' => 'Home Page',
        'icon' => '🏠',
        'url' => '../pages/index.php',
        'groups' => [
            'Hero Section' => [
                ['section' => 'hero_eyebrow', 'label' => 'Hero Eyebrow', 'type' => 'text', 'default' => 'Caring for Nepal since 1999'],
                ['section' => 'hero_title', 'label' => 'Hero Title', 'type' => 'text', 'default' => 'Welcome to International Nepal Fellowship (Nepal)'],
                ['section' => 'hero_subtitle', 'label' => 'Hero Subtitle', 'type' => 'textarea', 'rows' => 3, 'default' => 'Home Hospital is committed to providing world-class healthcare with modern technology, expert specialists and patient-centered service, 24 hours a day.'],
            ],
            'Stats Bar' => [
                ['section' => 'stat_1_value', 'label' => 'Stat 1 — Value', 'type' => 'text', 'default' => '25+'],
                ['section' => 'stat_1_label', 'label' => 'Stat 1 — Label', 'type' => 'text', 'default' => 'Years of Service'],
                ['section' => 'stat_2_value', 'label' => 'Stat 2 — Value', 'type' => 'text', 'default' => '150+'],
                ['section' => 'stat_2_label', 'label' => 'Stat 2 — Label', 'type' => 'text', 'default' => 'Expert Doctors'],
                ['section' => 'stat_3_value', 'label' => 'Stat 3 — Value', 'type' => 'text', 'default' => '300+'],
                ['section' => 'stat_3_label', 'label' => 'Stat 3 — Label', 'type' => 'text', 'default' => 'Hospital Beds'],
                ['section' => 'stat_4_value', 'label' => 'Stat 4 — Value', 'type' => 'text', 'default' => '24/7'],
                ['section' => 'stat_4_label', 'label' => 'Stat 4 — Label', 'type' => 'text', 'default' => 'Emergency Care'],
            ],
            'Services Section' => [
                ['section' => 'services_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'What We Offer'],
                ['section' => 'services_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Core Services'],
                ['section' => 'services_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'From emergency care to specialized treatment, we offer a full spectrum of medical services under one roof.'],
                ['section' => 'services_view_all', 'label' => 'Button Label', 'type' => 'text', 'default' => 'View All Services'],
            ],
            'Doctors Section' => [
                ['section' => 'doctors_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Our Specialists'],
                ['section' => 'doctors_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Meet Our Doctors'],
                ['section' => 'doctors_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Experienced, board-certified specialists dedicated to your health and wellbeing.'],
                ['section' => 'doctors_find', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Find a Doctor'],
            ],
            'Health Packages Section' => [
                ['section' => 'packages_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Health Packages'],
                ['section' => 'packages_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Preventive Health Checkups'],
                ['section' => 'packages_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Affordable health packages designed for early detection and prevention.'],
                ['section' => 'packages_view_all', 'label' => 'Button Label', 'type' => 'text', 'default' => 'View All Packages'],
            ],
            'Call To Action' => [
                ['section' => 'cta_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Need Medical Assistance?'],
                ['section' => 'cta_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Our team is available 24/7. Book an appointment online or call our emergency line.'],
                ['section' => 'cta_btn', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Book an Appointment'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'about' => [
        'label' => 'About Us',
        'icon' => '🏥',
        'url' => '../pages/about.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'About Us'],
                ['section' => 'banner_subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'rows' => 2, 'default' => 'Compassionate care and advanced medicine — proudly serving our community for over 25 years.'],
            ],
            'Who We Are' => [
                ['section' => 'who_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Who We Are'],
                ['section' => 'who_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Healthcare That Puts People First'],
                ['section' => 'who_p1', 'label' => 'Paragraph 1', 'type' => 'textarea', 'rows' => 4, 'default' => 'Home Hospital has been serving the community for over 25 years, growing from a small clinic into a full-service, multi-specialty hospital. We combine modern medical technology with a compassionate, patient-first approach to deliver the highest standard of care.'],
                ['section' => 'who_p2', 'label' => 'Paragraph 2', 'type' => 'textarea', 'rows' => 4, 'default' => 'Our multidisciplinary team of doctors, nurses, and healthcare professionals work together to ensure every patient receives accurate diagnosis, effective treatment, and continuous support throughout their care journey.'],
                ['section' => 'who_feature_1', 'label' => 'Feature 1', 'type' => 'text', 'default' => 'Full multi-specialty care under one roof'],
                ['section' => 'who_feature_2', 'label' => 'Feature 2', 'type' => 'text', 'default' => 'Patient-first approach at every step'],
                ['section' => 'who_feature_3', 'label' => 'Feature 3', 'type' => 'text', 'default' => 'Modern technology, compassionate hands'],
            ],
            'Milestones' => [
                ['section' => 'milestones_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Our Journey'],
                ['section' => 'milestones_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Hospital Milestones'],
                ['section' => 'milestones_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'A quarter century of growth, innovation, and service to our community.'],
                ['section' => 'milestone_1_year', 'label' => 'Milestone 1 — Year', 'type' => 'text', 'default' => '2000'],
                ['section' => 'milestone_1_title', 'label' => 'Milestone 1 — Title', 'type' => 'text', 'default' => 'A Humble Beginning'],
                ['section' => 'milestone_1_desc', 'label' => 'Milestone 1 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Founded as a small community clinic in Pokhara with a handful of dedicated staff.'],
                ['section' => 'milestone_2_year', 'label' => 'Milestone 2 — Year', 'type' => 'text', 'default' => '2008'],
                ['section' => 'milestone_2_title', 'label' => 'Milestone 2 — Title', 'type' => 'text', 'default' => 'Becoming a Hospital'],
                ['section' => 'milestone_2_desc', 'label' => 'Milestone 2 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Expanded into a 100-bed multi-specialty hospital serving the wider region.'],
                ['section' => 'milestone_3_year', 'label' => 'Milestone 3 — Year', 'type' => 'text', 'default' => '2016'],
                ['section' => 'milestone_3_title', 'label' => 'Milestone 3 — Title', 'type' => 'text', 'default' => 'Advanced Diagnostics'],
                ['section' => 'milestone_3_desc', 'label' => 'Milestone 3 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Launched our advanced diagnostic and imaging center with modern technology.'],
                ['section' => 'milestone_4_year', 'label' => 'Milestone 4 — Year', 'type' => 'text', 'default' => '2026'],
                ['section' => 'milestone_4_title', 'label' => 'Milestone 4 — Title', 'type' => 'text', 'default' => '300+ Beds & Growing'],
                ['section' => 'milestone_4_desc', 'label' => 'Milestone 4 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Now serving thousands of patients every year with 300+ beds and expert teams.'],
            ],
            'Why Choose Us' => [
                ['section' => 'why_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Why Choose Us'],
                ['section' => 'why_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'The Home Hospital Difference'],
                ['section' => 'why_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Everything we do is designed around one goal — your health, comfort, and peace of mind.'],
                ['section' => 'why_1_title', 'label' => 'Card 1 — Title', 'type' => 'text', 'default' => 'Expert Specialists'],
                ['section' => 'why_1_desc', 'label' => 'Card 1 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => '150+ experienced, board-certified doctors across every major specialty.'],
                ['section' => 'why_2_title', 'label' => 'Card 2 — Title', 'type' => 'text', 'default' => '24/7 Emergency Care'],
                ['section' => 'why_2_desc', 'label' => 'Card 2 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Round-the-clock emergency and trauma care with rapid response teams.'],
                ['section' => 'why_3_title', 'label' => 'Card 3 — Title', 'type' => 'text', 'default' => 'Advanced Diagnostics'],
                ['section' => 'why_3_desc', 'label' => 'Card 3 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'State-of-the-art imaging and laboratory services for accurate, fast results.'],
                ['section' => 'why_4_title', 'label' => 'Card 4 — Title', 'type' => 'text', 'default' => 'Accredited Safety'],
                ['section' => 'why_4_desc', 'label' => 'Card 4 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Internationally recognized patient safety standards and infection control.'],
                ['section' => 'why_5_title', 'label' => 'Card 5 — Title', 'type' => 'text', 'default' => 'International Patients'],
                ['section' => 'why_5_desc', 'label' => 'Card 5 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Dedicated services including visa assistance, interpreters, and travel support.'],
                ['section' => 'why_6_title', 'label' => 'Card 6 — Title', 'type' => 'text', 'default' => 'Compassionate Care'],
                ['section' => 'why_6_desc', 'label' => 'Card 6 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'A warm, human approach that treats every patient like family.'],
            ],
            'Call To Action' => [
                ['section' => 'cta_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Ready to Experience Better Care?'],
                ['section' => 'cta_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Our team is available 24/7. Book an appointment online or call our emergency line.'],
                ['section' => 'cta_btn', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Book an Appointment'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'mission-vision' => [
        'label' => 'Mission & Vision',
        'icon' => '🎯',
        'url' => '../pages/mission-vision.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Mission & Vision'],
                ['section' => 'banner_subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'rows' => 2, 'default' => 'Our purpose and the future we are building — one patient at a time.'],
            ],
            'Our Purpose' => [
                ['section' => 'purpose_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Our Purpose'],
                ['section' => 'purpose_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Why We Exist'],
                ['section' => 'purpose_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Guided by a clear mission and a bold vision, we care for every patient like family.'],
            ],
            'Mission' => [
                ['section' => 'mission_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Mission'],
                ['section' => 'mission_text', 'label' => 'Text', 'type' => 'textarea', 'rows' => 4, 'default' => 'To provide compassionate, high-quality, and accessible healthcare services to every individual who walks through our doors, regardless of their background, using advanced medical technology and a patient-centered approach.'],
                ['section' => 'mission_points', 'label' => 'Key Points (one per line)', 'type' => 'textarea', 'rows' => 4, 'hint' => 'Each line becomes a bullet point.', 'default' => "Compassionate care for everyone, no exceptions\nAdvanced medical technology and expertise\nA patient-centered approach in everything we do"],
            ],
            'Vision' => [
                ['section' => 'vision_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Vision'],
                ['section' => 'vision_text', 'label' => 'Text', 'type' => 'textarea', 'rows' => 4, 'default' => 'To be the leading healthcare institution in Nepal, recognized for clinical excellence, innovative treatments, and a culture of empathy and continuous improvement.'],
                ['section' => 'vision_points', 'label' => 'Key Points (one per line)', 'type' => 'textarea', 'rows' => 4, 'hint' => 'Each line becomes a bullet point.', 'default' => "The leading healthcare institution in Nepal\nClinical excellence and innovative treatments\nA culture of empathy and continuous improvement"],
            ],
            'Core Values' => [
                ['section' => 'values_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Values'],
                ['section' => 'values_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Core Values'],
                ['section' => 'values_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'The principles that guide every decision we make, every single day.'],
                ['section' => 'value_1_title', 'label' => 'Value 1 — Title', 'type' => 'text', 'default' => 'Compassion'],
                ['section' => 'value_1_desc', 'label' => 'Value 1 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'We treat every patient with dignity, respect, and genuine care.'],
                ['section' => 'value_2_title', 'label' => 'Value 2 — Title', 'type' => 'text', 'default' => 'Excellence'],
                ['section' => 'value_2_desc', 'label' => 'Value 2 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'We strive for the highest standards in medical care and service.'],
                ['section' => 'value_3_title', 'label' => 'Value 3 — Title', 'type' => 'text', 'default' => 'Integrity'],
                ['section' => 'value_3_desc', 'label' => 'Value 3 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'We uphold transparency, ethics, and honesty in all we do.'],
                ['section' => 'value_4_title', 'label' => 'Value 4 — Title', 'type' => 'text', 'default' => 'Innovation'],
                ['section' => 'value_4_desc', 'label' => 'Value 4 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'We embrace new technologies and methods to improve patient outcomes.'],
                ['section' => 'value_5_title', 'label' => 'Value 5 — Title', 'type' => 'text', 'default' => 'Community'],
                ['section' => 'value_5_desc', 'label' => 'Value 5 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'We are committed to serving and uplifting our local community.'],
                ['section' => 'value_6_title', 'label' => 'Value 6 — Title', 'type' => 'text', 'default' => 'Teamwork'],
                ['section' => 'value_6_desc', 'label' => 'Value 6 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'We collaborate across disciplines to deliver comprehensive care.'],
            ],
            'Call To Action' => [
                ['section' => 'cta_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Join Us in Building a Healthier Community'],
                ['section' => 'cta_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Experience care driven by compassion, excellence, and innovation.'],
                ['section' => 'cta_btn', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Book an Appointment'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'contact' => [
        'label' => 'Contact Us',
        'icon' => '✉️',
        'url' => '../pages/contact.php',
        'groups' => [
            'Intro Section' => [
                ['section' => 'intro_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Get in Touch'],
                ['section' => 'intro_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3, 'default' => 'Have a question or need assistance? Reach out to us using the form, or contact us directly using the information below.'],
            ],
            'Location Section' => [
                ['section' => 'map_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Find Us'],
                ['section' => 'map_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Location'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'international-patients' => [
        'label' => 'International Patients',
        'icon' => '🌍',
        'url' => '../pages/international-patients.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'International Patients'],
            ],
            'Service Blocks' => [
                ['section' => 'ip_services_title', 'label' => 'Block 1 — Title', 'type' => 'text', 'default' => 'International Patient Services'],
                ['section' => 'ip_services_desc', 'label' => 'Block 1 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'A dedicated desk to assist international patients with appointment scheduling, doctor selection, medical record transfer, and coordination throughout their treatment journey.'],
                ['section' => 'ip_packages_title', 'label' => 'Block 2 — Title', 'type' => 'text', 'default' => 'Medical Packages'],
                ['section' => 'ip_packages_desc', 'label' => 'Block 2 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'All-inclusive treatment packages covering consultation, surgery, hospital stay, and follow-up care, tailored for international patients seeking treatment abroad.'],
                ['section' => 'ip_visa_title', 'label' => 'Block 3 — Title', 'type' => 'text', 'default' => 'Visa Assistance'],
                ['section' => 'ip_visa_desc', 'label' => 'Block 3 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Support with medical visa invitation letters and documentation required for entry, in coordination with local authorities.'],
                ['section' => 'ip_travel_title', 'label' => 'Block 4 — Title', 'type' => 'text', 'default' => 'Travel Support'],
                ['section' => 'ip_travel_desc', 'label' => 'Block 4 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Assistance with flight coordination, airport pickup, and local transportation for patients and their families.'],
                ['section' => 'ip_accommodation_title', 'label' => 'Block 5 — Title', 'type' => 'text', 'default' => 'Accommodation'],
                ['section' => 'ip_accommodation_desc', 'label' => 'Block 5 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Guidance on nearby hotels and guest houses offering comfortable stays for patients and accompanying family members.'],
                ['section' => 'ip_interpreter_title', 'label' => 'Block 6 — Title', 'type' => 'text', 'default' => 'Interpreter Services'],
                ['section' => 'ip_interpreter_desc', 'label' => 'Block 6 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Multilingual interpreters available to help patients communicate clearly with doctors and hospital staff.'],
                ['section' => 'ip_insurance_title', 'label' => 'Block 7 — Title', 'type' => 'text', 'default' => 'Insurance Information'],
                ['section' => 'ip_insurance_desc', 'label' => 'Block 7 — Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Assistance in understanding coverage, processing insurance claims, and coordinating with international insurance providers.'],
            ],
            'Call To Action' => [
                ['section' => 'cta_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Planning to Travel for Treatment?'],
                ['section' => 'cta_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Contact our international patient desk to start planning your visit.'],
                ['section' => 'cta_btn', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Contact Us'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'services' => [
        'label' => 'Services',
        'icon' => '🚑',
        'url' => '../pages/services.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Our Services'],
            ],
            'Call To Action' => [
                ['section' => 'cta_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Need to Schedule a Visit?'],
                ['section' => 'cta_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Book an appointment with the right department in just a few clicks.'],
                ['section' => 'cta_btn', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Book an Appointment'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'departments' => [
        'label' => 'Departments',
        'icon' => '🏛️',
        'url' => '../pages/departments.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Departments'],
            ],
            'Intro Section' => [
                ['section' => 'dept_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Specialties'],
                ['section' => 'dept_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Departments'],
                ['section' => 'dept_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'A full range of specialized departments staffed by expert consultants and modern equipment.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'find-doctor' => [
        'label' => 'Find a Doctor',
        'icon' => '🔍',
        'url' => '../pages/find-doctor.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Find a Doctor'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'careers' => [
        'label' => 'Careers',
        'icon' => '💼',
        'url' => '../pages/careers.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Careers'],
            ],
            'Intro Section' => [
                ['section' => 'careers_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Join Our Team'],
                ['section' => 'careers_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Current Openings'],
                ['section' => 'careers_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Build a rewarding career with us. Explore our current job openings below.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'health-packages' => [
        'label' => 'Health Packages',
        'icon' => '🩺',
        'url' => '../pages/health-packages.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Health Packages'],
            ],
            'Intro Section' => [
                ['section' => 'packages_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Preventive Care'],
                ['section' => 'packages_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Health Checkup Packages'],
                ['section' => 'packages_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Choose from a range of health packages designed for early detection and long-term wellness.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'lab-report' => [
        'label' => 'Lab Report',
        'icon' => '🧪',
        'url' => '../pages/lab-report.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Lab Report'],
            ],
            'Report Lookup' => [
                ['section' => 'report_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Report Access'],
                ['section' => 'report_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'View / Download Your Lab Report'],
                ['section' => 'report_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Enter your Report ID and registered phone number to securely access your test results.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'online-consultation' => [
        'label' => 'Online Consultation',
        'icon' => '💻',
        'url' => '../pages/online-consultation.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Online Consultation'],
            ],
            'Intro Section' => [
                ['section' => 'oc_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Consult a Doctor Online'],
                ['section' => 'oc_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 4, 'default' => "Can't visit us in person? Request a video or phone consultation with one of our specialists from the comfort of your home. Fill out the form and our team will confirm your appointment time."],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'book-appointment' => [
        'label' => 'Book an Appointment',
        'icon' => '📅',
        'url' => '../pages/book-appointment.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Book an Appointment'],
            ],
            'Intro Section' => [
                ['section' => 'ba_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => '4 Simple Steps'],
                ['section' => 'ba_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Schedule Your Visit'],
                ['section' => 'ba_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Select department, choose a doctor, pick your date & time, and fill in your details.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'doctor-schedule' => [
        'label' => 'Doctor Schedule',
        'icon' => '🗓️',
        'url' => '../pages/doctor-schedule.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Doctor Schedule'],
            ],
            'Intro Section' => [
                ['section' => 'ds_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Availability'],
                ['section' => 'ds_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Weekly Doctor Schedule'],
                ['section' => 'ds_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Check availability before booking your appointment.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'management-team' => [
        'label' => 'Management Team',
        'icon' => '👥',
        'url' => '../pages/management-team.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Management Team'],
                ['section' => 'banner_subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'rows' => 2, 'default' => 'The experienced leaders guiding our mission of compassionate, world-class healthcare.'],
            ],
            'Team Section' => [
                ['section' => 'mt_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Leadership'],
                ['section' => 'mt_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Meet Our Management Team'],
                ['section' => 'mt_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => "Experienced leaders guiding our hospital's mission to deliver exceptional healthcare."],
            ],
            'Call To Action' => [
                ['section' => 'cta_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Ready to Experience Better Care?'],
                ['section' => 'cta_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Our team is available 24/7. Book an appointment online or call our emergency line.'],
                ['section' => 'cta_btn', 'label' => 'Button Label', 'type' => 'text', 'default' => 'Book an Appointment'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'medical-technology' => [
        'label' => 'Medical Technology',
        'icon' => '🖥️',
        'url' => '../pages/medical-technology.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Medical Technology'],
            ],
            'Intro Section' => [
                ['section' => 'tech_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Technology'],
                ['section' => 'tech_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Advanced Medical Equipment'],
                ['section' => 'tech_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Our hospital is equipped with the latest medical technology to ensure accurate diagnosis and effective treatment.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'patient-care-safety' => [
        'label' => 'Patient Care & Safety',
        'icon' => '🛡️',
        'url' => '../pages/patient-care-safety.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Patient Care & Safety'],
            ],
            'Intro Section' => [
                ['section' => 'safety_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Safety First'],
                ['section' => 'safety_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Our Commitment to Your Safety'],
                ['section' => 'safety_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Patient safety is our highest priority. We follow international standards to ensure a safe and healing environment.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'research-education' => [
        'label' => 'Research & Education',
        'icon' => '📚',
        'url' => '../pages/research-education.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'Research & Education'],
            ],
            'Research' => [
                ['section' => 're_research_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Medical Research'],
                ['section' => 're_research_text', 'label' => 'Text', 'type' => 'textarea', 'rows' => 4, 'default' => 'Our hospital is committed to advancing medical knowledge through clinical research and trials. We collaborate with academic institutions and research organizations to study new treatments, improve patient outcomes, and contribute to the global medical community.'],
            ],
            'Education' => [
                ['section' => 're_education_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Medical Education'],
                ['section' => 're_education_text', 'label' => 'Text', 'type' => 'textarea', 'rows' => 4, 'default' => 'We are dedicated to training the next generation of healthcare professionals. Our hospital serves as a teaching institution offering residency programs, nursing training, and continuing medical education for practicing doctors.'],
            ],
            'Resources Section' => [
                ['section' => 're_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Learn More'],
                ['section' => 're_resources_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Educational Resources'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'news-events' => [
        'label' => 'News & Events',
        'icon' => '📰',
        'url' => '../pages/news-events.php',
        'groups' => [
            'Page Banner' => [
                ['section' => 'banner_title', 'label' => 'Page Title', 'type' => 'text', 'default' => 'News and Events'],
            ],
            'News Section' => [
                ['section' => 'news_kicker', 'label' => 'Kicker', 'type' => 'text', 'default' => 'Stay Updated'],
                ['section' => 'news_title', 'label' => 'Heading', 'type' => 'text', 'default' => 'Latest News & Upcoming Events'],
                ['section' => 'news_text', 'label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'default' => 'Hospital news, health campaigns, medical seminars, and community programs.'],
            ],
        ],
    ],

    // ----------------------------------------------------------------
    'global' => [
        'label' => 'Site Settings',
        'icon' => '⚙️',
        'url' => '../index.php',
        'groups' => [
            'Contact Details' => [
                ['section' => 'address', 'label' => 'Address', 'type' => 'text', 'default' => defined('SITE_ADDRESS') ? SITE_ADDRESS : 'Pokhara, Gandaki Pradesh, Nepal'],
                ['section' => 'phone', 'label' => 'Phone', 'type' => 'text', 'default' => defined('SITE_PHONE') ? SITE_PHONE : '+977-61-000000'],
                ['section' => 'emergency', 'label' => 'Emergency Line', 'type' => 'text', 'default' => defined('SITE_EMERGENCY') ? SITE_EMERGENCY : '+977-61-911911'],
                ['section' => 'email', 'label' => 'Email', 'type' => 'text', 'default' => defined('SITE_EMAIL') ? SITE_EMAIL : 'info@homehospital.com'],
            ],
            'Header & Footer' => [
                ['section' => 'topbar_hours', 'label' => 'Opening Hours (top bar)', 'type' => 'text', 'default' => 'Open 24 Hours · 7 Days'],
                ['section' => 'footer_text', 'label' => 'Footer About Text', 'type' => 'textarea', 'rows' => 3, 'default' => (defined('SITE_TAGLINE') ? SITE_TAGLINE . '. ' : '') . 'Providing quality, compassionate healthcare to our community with modern medical technology and dedicated specialists.'],
            ],
        ],
    ],
];

// Flatten defaults for fast lookup by the content() helper.
$__defaults = [];
foreach ($__pages as $__pageKey => $__pageCfg) {
    foreach ($__pageCfg['groups'] as $__fields) {
        foreach ($__fields as $__field) {
            $__defaults[$__pageKey . "\x1F" . $__field['section']] = (string) ($__field['default'] ?? '');
        }
    }
}

return ['pages' => $__pages, 'defaults' => $__defaults];
