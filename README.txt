HOME HOSPITAL WEBSITE (PHP)
============================

DATABASE (MySQL / MariaDB)
---------------------------
This project uses MySQL (MariaDB on XAMPP) by default. Connection settings
live in includes/db-config.php and can be overridden with environment
variables (DB_DRIVER, DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS).

  - Import in phpMyAdmin (option A):
    1. Open phpMyAdmin (http://localhost/phpmyadmin).
    2. Go to the Import tab and choose database/schema.mysql.sql.
       It creates the database automatically — you do NOT need to
       select one first.
    3. Default admin password after import: ChangeMe@2026!
       (change it immediately via the admin panel -> Change Password)

  - Run the migration script (option B, recommended):
      php database/migrate.php
    This creates the 'hospital' database, applies the schema, seeds data,
    and writes a random admin password to storage/admin-password.txt.

HOW TO RUN
----------
Option 1 - PHP Built-in Server (quickest way to preview):
  1. Install PHP (8.0+) if not already installed.
  2. Open a terminal in this folder.
  3. Run:  php -S localhost:8000 router.php
  4. Open http://localhost:8000 in your browser.

  NOTE: use router.php (not plain `php -S`) so that sensitive files are
  blocked, the same way .htaccess protects them under Apache.

Option 2 - XAMPP / WAMP / LAMP:
  1. Copy this entire folder into your server's web root
     (e.g. htdocs/ for XAMPP, or /var/www/html/ for LAMP).
  2. Rename the folder if you like (e.g. "hospital").
  3. Start Apache (and MySQL, if you later add a database).
  4. Visit http://localhost/hospital/ in your browser.

Option 3 - Any shared PHP hosting:
  1. Upload all files/folders via FTP to your hosting account's
     public_html (or www) directory.
  2. Visit your domain in the browser.

FOLDER STRUCTURE
----------------
index.php                  - Homepage shim (loads pages/index.php so the site URL stays /index.php)
router.php                 - Router for the PHP built-in server (php -S localhost:8000 router.php)

pages/                     - Public page entry points (kept in one folder for tidiness & security)
  index.php                - Homepage
  about.php                - About Us
  mission-vision.php       - Mission & Vision
  management-team.php      - Management Team
  departments.php          - Departments
  medical-technology.php   - Medical Technology
  patient-care-safety.php  - Patient Care & Safety
  health-packages.php      - Health Packages
  research-education.php   - Research & Education
  careers.php              - Careers (with job application form)
  news-events.php          - News and Events
  contact.php              - Contact Us (with contact form)
  services.php             - Our Services (all service types, anchor sections)
  find-doctor.php          - Find a Doctor (search by name/department/specialty)
  doctor-schedule.php      - Doctor Schedule table
  online-consultation.php  - Online Consultation request form
  book-appointment.php     - Book an Appointment (full booking form)
  international-patients.php - International Patients services
  lab-report.php           - Lab Report lookup/view/download/verification

app/Views/pages/           - Page templates rendered by the entry points above
app/Views/layouts/         - Shared site header/footer layouts

includes/config.php        - Site-wide settings & sample data (departments, doctors, packages, news)
includes/header.php        - Shared header & navigation menu
includes/footer.php        - Shared footer
css/style.css               - All site styling
js/script.js                - Mobile menu toggle & tab logic

NOTES
-----
- Content is stored in a MySQL database (default name: hospital) and every
  query goes through PDO prepared statements. The project is structured
  using the MVC pattern:
    * app/Models/     — data access (one class per table)
    * app/Views/      — HTML templates (layouts, pages, admin)
    * page files      — thin controllers that fetch models and render views
- Admin panel: /admin/login.php  (username: admin)
  - If you imported via phpMyAdmin, the initial password is ChangeMe@2026!
  - If you ran `php database/migrate.php`, the password is auto-generated
    and written to storage/admin-password.txt (blocked from web access).
  - Change the password immediately after first login via the
    "Change Password" page in the admin panel.
  - Lost your password? Run:  php tools/reset-admin-password.php
- Security features included:
  * CSRF tokens on every form (public + admin)
  * SQL injection protection (PDO prepared statements)
  * XSS protection (output escaping + Content-Security-Policy)
  * Admin brute-force login throttling (5 attempts / 15 min per IP)
  * Session hardening (HttpOnly, SameSite, strict mode, regeneration on login)
  * Security headers (CSP, X-Frame-Options, nosniff, Referrer-Policy)
  * Database, logs and include files blocked from direct web access
    (.htaccess under Apache, router.php under php -S)
  * Errors logged to storage/php-errors.log, never shown to visitors
    (set the APP_DEBUG environment variable to 1 to see them in development)
- Forms (Contact, Careers, Book Appointment, Online Consultation,
  Lab Report lookup) are functional and now SAVE their data to the
  database (appointments, contacts, online_consultations,
  career_applications tables). Emails/SMS are not sent yet.
- Try the Lab Report demo with:
    Report ID: HH-LAB-1001   Phone: 9800000001
    Report ID: HH-LAB-1002   Phone: 9800000002
- To customize hospital name, phone, email, and address, edit the
  constants at the top of includes/config.php.
- To manage departments/doctors/packages/news, use the admin panel at
  /admin/login.php instead of editing files directly.
