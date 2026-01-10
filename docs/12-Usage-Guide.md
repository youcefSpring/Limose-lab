# 12-Usage-Guide.md

## Guide d'Installation et d'Utilisation - RLMS

---

## 1. Prérequis Système

### Logiciels Requis
```
- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x
- npm >= 9.x
- MySQL >= 8.0
- Git
```

### Extensions PHP Requises
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
- GD (pour images)
- Intl (pour i18n)
```

---

## 2. Installation

### 2.1 Cloner le Projet
```bash
git clone <repository-url> rlms
cd rlms
```

### 2.2 Installer Dépendances Backend
```bash
composer install
```

### 2.3 Installer Dépendances Frontend
```bash
npm install
```

### 2.4 Configuration Environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 2.5 Configurer .env
```env
APP_NAME="RLMS"
APP_ENV=local
APP_KEY=base64:xxx (généré)
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_LOCALE=ar
APP_FALLBACK_LOCALE=en
APP_TIMEZONE=Africa/Algiers

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rlms_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rlms.local
MAIL_FROM_NAME="${APP_NAME}"

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_DRIVER=file

FILESYSTEM_DISK=local
```

### 2.6 Créer Base de Données
```bash
mysql -u root -p
CREATE DATABASE rlms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 2.7 Migrations et Seeds
```bash
php artisan migrate
php artisan db:seed
```

### 2.8 Créer Lien Symbolique Storage
```bash
php artisan storage:link
```

### 2.9 Compiler Assets Frontend
```bash
npm run build
# ou pour développement avec hot-reload:
npm run dev
```

### 2.10 Lancer Serveur
```bash
php artisan serve
```

Accéder : `http://localhost:8000`

### 2.11 Lancer Queue Worker (pour emails)
Terminal séparé :
```bash
php artisan queue:work
```

---

## 3. Utilisateurs par Défaut (après seed)

### Admin
```
Email: admin@rlms.local
Password: password
Rôle: admin
```

### Material Manager
```
Email: manager@rlms.local
Password: password
Rôle: material_manager
```

### Researcher
```
Email: researcher@rlms.local
Password: password
Rôle: researcher
```

### Technician
```
Email: technician@rlms.local
Password: password
Rôle: technician
```

---

## 4. Configuration Avancée

### 4.1 Configurer Tâches Planifiées (Cron)

Ajouter au crontab :
```bash
crontab -e
```

Ajouter ligne :
```
* * * * * cd /path-to-rlms && php artisan schedule:run >> /dev/null 2>&1
```

Tâches planifiées définies dans `app/Console/Kernel.php` :
- Envoi reminders événements (daily 08:00)
- Vérification suspensions expirées (hourly)
- Mise à jour maintenances planifiées (daily)

### 4.2 Configurer Queue Worker Permanent (Supervisor)

Installer supervisor :
```bash
sudo apt-get install supervisor
```

Créer config `/etc/supervisor/conf.d/rlms-worker.conf` :
```ini
[program:rlms-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-rlms/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-rlms/storage/logs/worker.log
```

Recharger supervisor :
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start rlms-worker:*
```

### 4.3 Optimisation Production

```bash
# Cacher config
php artisan config:cache

# Cacher routes
php artisan route:cache

# Cacher views
php artisan view:cache

# Optimiser autoloader
composer install --optimize-autoloader --no-dev

# Compiler assets production
npm run build
```

---

## 5. Internationalisation (i18n)

### 5.1 Langue par Défaut

Définie dans `.env` :
```env
APP_LOCALE=ar  # ar, fr, ou en
```

### 5.2 Ajouter Traductions

Fichiers dans `resources/lang/{locale}/` :
```
resources/lang/
  ├── ar/
  │   ├── auth.php
  │   ├── validation.php
  │   ├── messages.php
  │   └── ...
  ├── fr/
  └── en/
```

Format PHP array :
```php
// resources/lang/fr/messages.php
return [
    'welcome' => 'Bienvenue',
    'logout' => 'Se déconnecter',
];

// resources/lang/ar/messages.php
return [
    'welcome' => 'مرحبا',
    'logout' => 'تسجيل الخروج',
];
```

### 5.3 Utilisation dans Blade
```blade
{{ __('messages.welcome') }}
{{ trans('auth.failed') }}
```

### 5.4 Support RTL (Arabe)

Dans `resources/views/layouts/app.blade.php` :
```blade
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
```

Tailwind config RTL (automatique si dir="rtl")

---

## 6. Gestion Permissions (Spatie)

### 6.1 Assigner Rôle
```php
$user->assignRole('researcher');
```

### 6.2 Vérifier Rôle
```php
if ($user->hasRole('admin')) {
    // ...
}
```

### 6.3 Assigner Permission
```php
$user->givePermissionTo('manage-materials');
```

### 6.4 Vérifier Permission
```php
if ($user->can('approve-reservations')) {
    // ...
}
```

### 6.5 Middleware Routes
```php
Route::get('/admin', function() {
    // ...
})->middleware(['auth', 'role:admin']);

Route::post('/reservations/{id}/approve', [...])
    ->middleware(['auth', 'permission:approve-reservations']);
```

---

## 7. Utilisation Quotidienne

### 7.1 Chercheur - Créer Réservation

1. Connexion avec identifiants
2. Navigation : Dashboard → Matériel
3. Rechercher/filtrer équipement souhaité
4. Clic "Réserver"
5. Remplir dates, quantité, justification
6. Soumettre → statut "En attente"
7. Email notification material manager
8. Attendre approbation

### 7.2 Material Manager - Valider Réservation

1. Connexion
2. Navigation : Réservations → En attente
3. Consulter détails demande
4. Vérifier disponibilité (calendrier)
5. Clic "Approuver" ou "Rejeter"
6. Si rejet : saisir motif
7. Email notification demandeur

### 7.3 Admin - Approuver Nouvel Utilisateur

1. Connexion admin
2. Navigation : Administration → Utilisateurs en attente
3. Consulter profil demandeur
4. Clic "Approuver"
5. Sélectionner rôle approprié
6. Confirmer
7. Email notification utilisateur

### 7.4 Chercheur - Créer Projet

1. Navigation : Projets → Nouveau projet
2. Remplir titre, description, dates
3. Assigner membres équipe
4. Soumettre
5. Notifications membres assignés

### 7.5 Technicien - Planifier Maintenance

1. Navigation : Maintenance → Nouvelle maintenance
2. Sélectionner équipement
3. Type : préventive/corrective
4. Date planifiée
5. Description
6. Soumettre → équipement statut "maintenance"
7. Réservations futures annulées automatiquement

---

## 8. Tests

### 8.1 Tests Unitaires
```bash
php artisan test --filter=Unit
```

### 8.2 Tests Fonctionnels
```bash
php artisan test --filter=Feature
```

### 8.3 Tous les Tests
```bash
php artisan test
```

### 8.4 Tests avec Couverture
```bash
php artisan test --coverage
```

---

## 9. Maintenance

### 9.1 Logs
```bash
# Consulter logs Laravel
tail -f storage/logs/laravel.log

# Nettoyer vieux logs
php artisan log:clear
```

### 9.2 Cache
```bash
# Vider cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuilder cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9.3 Backup Base de Données
```bash
mysqldump -u root -p rlms_db > backup_$(date +%Y%m%d).sql
```

### 9.4 Restauration
```bash
mysql -u root -p rlms_db < backup_20240101.sql
```

---

## 10. Troubleshooting

### Problème : Storage Permission Denied
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Problème : CSRF Token Mismatch
- Vider cache navigateur
- Vérifier APP_KEY généré
- `php artisan config:clear`

### Problème : Queue Jobs Non Traités
- Vérifier queue worker actif : `ps aux | grep queue`
- Redémarrer worker : `php artisan queue:restart`
- Consulter failed_jobs : `php artisan queue:failed`
- Retry : `php artisan queue:retry all`

### Problème : Emails Non Envoyés
- Vérifier config MAIL_ dans .env
- Tester : `php artisan tinker` puis `Mail::raw('Test', function($m) { $m->to('test@example.com'); });`
- Consulter queue : `php artisan queue:work --once`

---

## 11. Sécurité

### 11.1 Production Checklist
- [ ] `APP_DEBUG=false` dans .env
- [ ] Mot de passe DB fort
- [ ] Sauvegardes régulières
- [ ] HTTPS activé
- [ ] Firewall configuré
- [ ] Logs rotatifs
- [ ] Queue worker supervisé
- [ ] Limiter tentatives login (throttle)

### 11.2 Mise à Jour Dépendances
```bash
composer update
npm update
php artisan migrate
```

---

## 12. Support

### Documentation
- Laravel : https://laravel.com/docs
- Tailwind CSS : https://tailwindcss.com/docs
- Spatie Permission : https://spatie.be/docs/laravel-permission

### Logs Application
`storage/logs/laravel.log`

---

## Prochaines étapes

- Consulter **10-Module.md** pour détails modules
- Voir **11-User-Stories.md** pour cas d'usage
