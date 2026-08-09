# Admin Panel

Use the admin panel to manage site content.

Sections
--------

- **Overview** — dashboard with live counts and recent activity
- **Departments / Doctors / Services / Health Packages / Team Members /
  Lab Reports / News & Events** — full add, edit, delete management
  (Lab Reports also has per-report result parameters)
- **Appointments / Messages / Consultations / Applications** — inbox with
  status actions (confirm / mark read / reviewed), delete, and search
- **Change Password** — update your admin credentials

- Admin login: `/admin/login.php`  (username: `admin`)
- The site runs on **MySQL** (database `hospital` by default — see
  `includes/db-config.php`). Set up the database with either:
  - `php database/migrate.php` (generates a random admin password and saves
    it to `storage/admin-password.txt`), or
  - Import `database/schema.mysql.sql` in phpMyAdmin (initial password:
    `ChangeMe@2026!`).
- **Change your password immediately** after the first login via
  **Change Password** in the admin navigation.
- **Upgrading an existing MySQL install** to the latest schema: run
  `php database/migrate.php` (note: this recreates all tables and drops
  existing data), or apply the change manually, e.g.
  `ALTER TABLE services ADD COLUMN image_url VARCHAR(255) DEFAULT NULL;`
- If you lose the password, reset it from the command line:

  ```
  php tools/reset-admin-password.php
  ```

Security features: password hashing (bcrypt), session regeneration on login,
CSRF protection on every form, brute-force login throttling, and
Content-Security-Policy + other hardening headers.
