CI4 Secure Auth - Demo
=======================

What this package contains:
- Controllers: Auth, Captcha (slider/puzzle), OTP, Dashboard
- Models: UserModel, RoleModel, LoginAttemptModel
- Filters: CekLogin, CekRole, SecureHeaders
- Helpers: auth_helper, captcha_helper, mail_helper, role_helper
- Views: login, register, dashboard, captcha fragments
- Migrations: create roles, users, login_attempts, password_resets, auth_logs
- Public assets: slider.js, puzzle.js, style.css
- .env template (configure DB, recaptcha, SMTP, encryption)

Quick start:
1. Extract files to your CodeIgniter 4 project root (backup first).
2. Copy migration files to app/Database/Migrations/ (already there in package).
3. Update app/Config/Filters.php: add aliases 'login' => \App\Filters\CekLogin::class; 'role' => \App\Filters\CekRole::class
4. Add routes snippet from app/Config/RoutesSnippet.txt into your Routes.php.
5. Update .env (DB, recaptcha keys, SMTP, encryption.key via php spark key:generate).
6. Run migrations: php spark migrate
7. Ensure writable directories are writable (WRITEPATH/session).
8. Visit /register and /login.

Notes:
- This is a demo scaffold. Replace dummy logic (e.g., user lookup/verification) with production-ready code.
- Enable HTTPS before going live and set session.cookieSecure = true in .env.
- Tweak rules, password hashing, and TOTP integration as needed.
