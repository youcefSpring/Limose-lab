# 99-References.md

## Références et Ressources Externes

---

## 1. Documentation Frameworks & Bibliothèques

### Laravel
- **Documentation officielle :** https://laravel.com/docs/11.x
- **Laravel Breeze (Auth):** https://laravel.com/docs/11.x/starter-kits#breeze
- **Laravel Jetstream (Auth avancé):** https://jetstream.laravel.com/
- **Eloquent ORM:** https://laravel.com/docs/11.x/eloquent
- **Blade Templates:** https://laravel.com/docs/11.x/blade
- **Validation:** https://laravel.com/docs/11.x/validation
- **Queue & Jobs:** https://laravel.com/docs/11.x/queues
- **Mail:** https://laravel.com/docs/11.x/mail
- **Notifications:** https://laravel.com/docs/11.x/notifications

### Tailwind CSS
- **Documentation :** https://tailwindcss.com/docs
- **Installation Laravel :** https://tailwindcss.com/docs/guides/laravel
- **RTL Support :** https://tailwindcss.com/docs/hover-focus-and-other-states#rtl-support
- **Components :** https://tailwindui.com/ (payant, recommandé)
- **Free Components :** https://flowbite.com/

### Alpine.js
- **Documentation :** https://alpinejs.dev/
- **Start Here :** https://alpinejs.dev/start-here
- **Directives :** https://alpinejs.dev/directives

### Axios
- **Documentation :** https://axios-http.com/docs/intro
- **Laravel Integration :** Inclus par défaut dans Laravel

---

## 2. Packages Laravel Utilisés

### Spatie Laravel Permission
- **Repository :** https://github.com/spatie/laravel-permission
- **Documentation :** https://spatie.be/docs/laravel-permission/v6/introduction
- **Installation :** `composer require spatie/laravel-permission`

### Laravel Excel (Export rapports)
- **Repository :** https://github.com/SpartnerNL/Laravel-Excel
- **Documentation :** https://docs.laravel-excel.com/
- **Installation :** `composer require maatwebsite/excel`

### Laravel DomPDF (Export PDF)
- **Repository :** https://github.com/barryvdh/laravel-dompdf
- **Documentation :** https://github.com/barryvdh/laravel-dompdf#usage
- **Installation :** `composer require barryvdh/laravel-dompdf`

### Spatie Laravel Activity Log (Optionnel)
- **Repository :** https://github.com/spatie/laravel-activitylog
- **Documentation :** https://spatie.be/docs/laravel-activitylog/v4/introduction
- **Installation :** `composer require spatie/laravel-activitylog`

---

## 3. Frontend Libraries

### Chart.js (Graphiques)
- **Documentation :** https://www.chartjs.org/docs/latest/
- **Getting Started :** https://www.chartjs.org/docs/latest/getting-started/
- **Installation :** `npm install chart.js`

### ApexCharts (Alternative Chart.js)
- **Documentation :** https://apexcharts.com/docs/
- **Installation :** `npm install apexcharts`

### FullCalendar (Calendrier événements/réservations)
- **Documentation :** https://fullcalendar.io/docs
- **Installation :** `npm install @fullcalendar/core @fullcalendar/daygrid @fullcalendar/timegrid @fullcalendar/interaction`

### Flatpickr (Date Picker)
- **Documentation :** https://flatpickr.js.org/
- **Installation :** `npm install flatpickr`

---

## 4. Design & UI Inspiration

### Tailwind UI Components (Payant mais excellent)
- **Site :** https://tailwindui.com/
- **Prix :** ~$299 accès à vie
- **Inclut :** Dashboards, forms, tables, calendars

### Flowbite (Gratuit)
- **Site :** https://flowbite.com/
- **Components :** https://flowbite.com/docs/getting-started/introduction/
- **Tailwind-based, open-source**

### DaisyUI (Gratuit)
- **Site :** https://daisyui.com/
- **Installation :** `npm install daisyui`

### Heroicons (Icons)
- **Site :** https://heroicons.com/
- **Utilisation :** SVG icons, compatible Blade

---

## 5. Outils Développement

### Laravel Debugbar
- **Repository :** https://github.com/barryvdh/laravel-debugbar
- **Installation :** `composer require barryvdh/laravel-debugbar --dev`
- **Usage :** Affiche queries SQL, performance, variables

### Laravel IDE Helper
- **Repository :** https://github.com/barryvdh/laravel-ide-helper
- **Installation :** `composer require --dev barryvdh/laravel-ide-helper`
- **Usage :** Autocomplétion IDE pour Facades, Models

### Laravel Telescope (Monitoring)
- **Documentation :** https://laravel.com/docs/11.x/telescope
- **Installation :** `composer require laravel/telescope`
- **Usage :** Debug, monitoring requêtes, jobs, cache

---

## 6. Testing

### PHPUnit
- **Documentation :** https://docs.phpunit.de/en/10.5/
- **Laravel Testing :** https://laravel.com/docs/11.x/testing

### Laravel Dusk (Browser Tests)
- **Documentation :** https://laravel.com/docs/11.x/dusk
- **Installation :** `composer require --dev laravel/dusk`

### Pest (Alternative PHPUnit, moderne)
- **Documentation :** https://pestphp.com/
- **Installation :** `composer require pestphp/pest --dev --with-all-dependencies`

---

## 7. Déploiement & Infrastructure

### Laravel Forge (Serveur management)
- **Site :** https://forge.laravel.com/
- **Prix :** À partir de $12/mois
- **Usage :** Provisioning serveurs, déploiements automatiques

### Laravel Vapor (Serverless)
- **Site :** https://vapor.laravel.com/
- **Prix :** À partir de $39/mois
- **Usage :** Déploiement serverless sur AWS

### DigitalOcean
- **Site :** https://www.digitalocean.com/
- **1-Click Laravel :** https://marketplace.digitalocean.com/apps/laravel
- **Prix :** À partir de $6/mois

### Docker
- **Laravel Sail :** https://laravel.com/docs/11.x/sail
- **Docker Compose :** Inclus avec Laravel (docker-compose.yml)

---

## 8. Sécurité

### OWASP Top 10
- **Site :** https://owasp.org/www-project-top-ten/
- **Laravel Security Best Practices :** https://cheatsheetseries.owasp.org/cheatsheets/Laravel_Cheat_Sheet.html

### Laravel Security Checklist
- **Article :** https://laravel-news.com/laravel-security-checklist

---

## 9. Internationalisation

### Laravel Localization
- **Documentation :** https://laravel.com/docs/11.x/localization
- **Package mcamara :** https://github.com/mcamara/laravel-localization (optionnel)

### RTL Support Tailwind
- **Guide :** https://tailwindcss.com/docs/hover-focus-and-other-states#rtl-support
- **Plugin :** Aucun plugin nécessaire, native support avec `dir="rtl"`

---

## 10. Performance & Optimization

### Laravel Optimization
- **Guide officiel :** https://laravel.com/docs/11.x/deployment#optimization
- **Config cache :** `php artisan config:cache`
- **Route cache :** `php artisan route:cache`
- **View cache :** `php artisan view:cache`

### Redis
- **Documentation :** https://redis.io/docs/
- **Laravel Redis :** https://laravel.com/docs/11.x/redis
- **Installation :** `composer require predis/predis`

### Laravel Horizon (Queue monitoring)
- **Documentation :** https://laravel.com/docs/11.x/horizon
- **Installation :** `composer require laravel/horizon`

---

## 11. Emails

### Mailtrap (Dev/Test)
- **Site :** https://mailtrap.io/
- **Usage :** Tester emails sans les envoyer réellement
- **Gratuit :** 500 emails/mois

### SendGrid (Production)
- **Site :** https://sendgrid.com/
- **Free tier :** 100 emails/jour
- **Laravel Integration :** https://sendgrid.com/docs/for-developers/sending-email/laravel/

### Mailgun (Production)
- **Site :** https://www.mailgun.com/
- **Free tier :** 5000 emails/mois (3 premiers mois)

---

## 12. Backup & Monitoring

### Laravel Backup (Spatie)
- **Repository :** https://github.com/spatie/laravel-backup
- **Documentation :** https://spatie.be/docs/laravel-backup/v8/introduction
- **Installation :** `composer require spatie/laravel-backup`

### Sentry (Error tracking)
- **Site :** https://sentry.io/
- **Laravel Integration :** `composer require sentry/sentry-laravel`
- **Documentation :** https://docs.sentry.io/platforms/php/guides/laravel/

---

## 13. API Documentation (Future)

### Swagger / OpenAPI
- **Package :** https://github.com/DarkaOnLine/L5-Swagger
- **Documentation :** https://swagger.io/docs/

### Postman
- **Site :** https://www.postman.com/
- **Usage :** Tester et documenter APIs

---

## 14. Versioning & Git

### GitHub
- **Site :** https://github.com/
- **Git Flow :** https://nvie.com/posts/a-successful-git-branching-model/

### GitLab
- **Site :** https://about.gitlab.com/
- **CI/CD :** https://docs.gitlab.com/ee/ci/

---

## 15. Ressources Apprentissage

### Laracasts
- **Site :** https://laracasts.com/
- **Prix :** $15/mois
- **Contenu :** Vidéos tutoriels Laravel de qualité

### Laravel Daily
- **Site :** https://laraveldaily.com/
- **Blog :** Tips quotidiens, articles

### Laravel News
- **Site :** https://laravel-news.com/
- **Newsletter :** Actualités Laravel hebdomadaires

---

## 16. Community & Support

### Laravel Forums
- **Laracasts Forum :** https://laracasts.com/discuss
- **Laravel.io :** https://laravel.io/forum

### Stack Overflow
- **Laravel Tag :** https://stackoverflow.com/questions/tagged/laravel

### Discord
- **Laravel Discord :** https://discord.gg/laravel

---

## 17. Licence & Legal

### Laravel Licence
- **MIT License :** Open source, utilisation commerciale autorisée
- **Lien :** https://github.com/laravel/laravel/blob/11.x/LICENSE.md

### Tailwind CSS Licence
- **MIT License**
- **Lien :** https://github.com/tailwindlabs/tailwindcss/blob/master/LICENSE

---

## 18. Diagrams & Documentation

### Mermaid (Diagrammes)
- **Documentation :** https://mermaid.js.org/
- **Usage :** Diagrammes as code (Markdown)

### Draw.io / Diagrams.net
- **Site :** https://www.drawio.com/
- **Usage :** Diagrammes UML, architecture

---

## 19. Code Quality

### Laravel Pint (Code Styling)
- **Documentation :** https://laravel.com/docs/11.x/pint
- **Usage :** `./vendor/bin/pint`

### PHPStan (Static Analysis)
- **Site :** https://phpstan.org/
- **Laravel Extension :** https://github.com/nunomaduro/larastan
- **Installation :** `composer require nunomaduro/larastan --dev`

---

## 20. Autres Ressources

### Laravel Cheat Sheet
- **Site :** https://laravel-cheatsheet.com/

### DevDocs (Documentation offline)
- **Site :** https://devdocs.io/
- **Inclut :** Laravel, PHP, MySQL, JavaScript

---

## Prochaines étapes

- Consulter **GAPS-TODO.md** pour points à clarifier
- Commencer développement en suivant **12-Usage-Guide.md**
