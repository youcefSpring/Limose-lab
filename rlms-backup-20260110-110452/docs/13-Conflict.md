# 13-Conflict.md

## Conflits Potentiels et Décisions Architecturales (ADR)

Ce document identifie les conflits potentiels, ambiguïtés, et décisions prises pour le projet RLMS.

---

## 1. Architecture : Web vs API + Apps

### Conflit
Le document initial mentionne une plateforme "moderne" mais ne précise pas clairement si des applications mobiles sont prévues. ==> application web

### Décision (ADR-001)
**Choix :** Architecture A - Laravel Web Only ==> oui
**Raison :**
- Aucune mention explicite d'apps mobiles dans le cahier des charges
- Cible principale : utilisateurs de bureau (chercheurs, administrateurs)
- Interface responsive suffit pour accès mobile via navigateur
- Simplification développement et maintenance


---

## 2. Système de Paiement

### Conflit
Le document ne mentionne pas de système de paiement, mais on pourrait penser à un accès payant au laboratoire ou aux équipements.

### Décision (ADR-002)
**Choix :** Pas de module de paiement
**Raison :**
- Non mentionné dans le cahier des charges
- Laboratoire de recherche typiquement gratuit pour membres autorisés
- Confirmation utilisateur lors du questionnaire initial

**Alternative considérée :**
- Intégration CCP/Baridi pour réservations payantes : rejetée

**Impact :**
- Pas de tables payments/subscriptions
- Accès gratuit après approbation admin
- Simplification workflow réservations

---

## 3. Validation des Réservations

### Conflit
Ambiguïté sur le processus de validation : automatique ou manuelle ?

### Décision (ADR-003)
**Choix :** Validation manuelle hybride
**Raison :**
- Rôle "Material Manager" dédié à la validation
- Administrateurs peuvent également valider
- Contrôle qualité et gestion optimale des ressources
- Confirmation utilisateur lors du questionnaire

**Alternative considérée :**
- Auto-approval si disponible : rejetée (manque de contrôle)
- Validation admin uniquement : rejetée (charge de travail)

**Impact :**
- États réservation : pending → approved/rejected
- Notifications à chaque changement d'état
- Dashboard pour material managers

**États de Réservation :**
```
pending → approved (by material_manager or admin)
pending → rejected (by material_manager or admin, avec motif)
pending/approved → cancelled (by user, avant date début)
approved → completed (automatique après date fin)
```

---

## 4. Notifications Temps Réel

### Conflit
"AJAX for dynamic interactions" mentionné, mais pas de précision sur WebSockets.

### Décision (ADR-004)
**Choix :** Email + Database notifications, pas de WebSockets
**Raison :**
- Confirmation utilisateur : pas besoin de temps réel strict
- Email + DB notifications suffisants pour cas d'usage
- Simplicité infrastructure (pas de Pusher/Reverb)
- AJAX polling pour badges notifications (acceptable)

**Alternative considérée :**
- WebSockets (Pusher/Laravel Reverb) : rejetée (over-engineering pour MVP)

**Impact :**
- Table `notifications` pour stockage
- Jobs queue pour envoi emails
- AJAX endpoint `/notifications/unread` pour polling

---

## 5. Langue par Défaut

### Conflit
Projet en Algérie mais documentation en français, public international potentiel.

### Décision (ADR-005)
**Choix :** Support multilingue ar/fr/en, défaut selon préférence utilisateur
**Raison :**
- Contexte algérien : arabe important
- Collaboration internationale : français/anglais utiles
- Flexibilité maximale

**Configuration :**
- Langues supportées : ar (RTL), fr, en
- Défaut configurable dans .env : APP_LOCALE
- Préférence utilisateur stockée en DB
- Détection automatique navigateur en fallback

**Impact :**
- Fichiers traduction : `resources/lang/{ar,fr,en}/`
- Support RTL dans Tailwind
- Middleware SetLocale
- Attribut `dir` dynamique sur `<html>`

---

## 6. Rôles Utilisateurs

### Conflit
Document mentionne "Researchers, PhD Students, Partial Researcher" : quelle différence ?

### Décision (ADR-006)
**Choix :** 7 rôles distincts avec permissions granulaires

**Rôles définis :**
1. **admin** : Super-admin, toutes permissions
2. **material_manager** : Validation réservations, gestion équipements
3. **researcher** : Chercheur complet, création projets
4. **phd_student** : Doctorant, membre projets, réservations
5. **partial_researcher** : Chercheur accès limité (pas création projets)
6. **technician** : Gestion maintenance, inventaire
7. **guest** : Lecture seule très limitée

**Raison :**
- Flexibilité gestion droits
- Correspond hiérarchie académique typique
- Spatie Permission permet gestion fine

**Impact :**
- Table `roles` avec 7 rôles initiaux
- Matrice permissions détaillée (voir 10-Module.md)
- Middleware role/permission sur routes

---

## 7. Durée Maximale Réservation

### Conflit
Non spécifié : peut-on réserver 6 mois d'affilée ?

### Décision (ADR-007)
**Choix :** Limite 30 jours par défaut, configurable
**Raison :**
- Éviter monopolisation équipements
- Rotation équitable
- Configurable dans `config/rlms.php` si besoin ajuster

**Configuration :**
```php
'reservation_limits' => [
    'max_duration_days' => 30,
    'max_active_per_user' => 3,
],
```

**Alternative considérée :**
- Pas de limite : rejetée (risque blocage ressources)

---

## 8. Gestion Conflits de Réservation

### Conflit
Si 5 unités d'un équipement, comment gérer les réservations chevauchantes ?

### Décision (ADR-008)
**Choix :** Calcul disponibilité dynamique avec détection conflits

**Algorithme :**
```
Pour une période [start, end] et quantité Q :
1. Trouver toutes réservations approved chevauchantes
2. Sommer quantités réservées
3. Comparer avec material.quantity
4. Disponible = material.quantity - SUM(reserved_quantities)
```

**Validation :**
- Côté frontend : AJAX check avant soumission
- Côté backend : validation stricte dans ReservationService
- Message d'erreur clair si conflit détecté

**Impact :**
- Méthode `ReservationService::validateAvailability()`
- Endpoint AJAX `/reservations/check-availability`
- Tests unitaires pour scénarios complexes

---

## 9. Maintenance Équipements vs Réservations Actives

### Conflit
Si un équipement passe en maintenance, que faire des réservations futures approved ?

### Décision (ADR-009)
**Choix :** Annulation automatique + notification

**Workflow :**
```
Material status → maintenance:
1. Annuler toutes réservations futures (approved, après today)
2. Statut réservations → cancelled
3. Notification email chaque utilisateur affecté
4. Motif : "Équipement en maintenance"
```

**Alternative considérée :**
- Laisser réservations actives : rejetée (incohérence)
- Demander confirmation admin : rejetée (lourdeur)

**Impact :**
- Observer MaterialObserver sur status change
- Listener CancelFutureReservations
- Notifications automatiques

---

## 10. Fichiers Expériences : Stockage

### Conflit
Fichiers publics ou privés ? Qui peut télécharger ?

### Décision (ADR-010)
**Choix :** Stockage privé, accès contrôlé via Policy

**Structure :**
```
storage/app/private/experiments/{year}/{month}/{filename}
```

**Téléchargement :**
- Route protégée : `/experiments/files/{id}/download`
- Policy : seulement membres du projet
- Laravel Storage avec `download()` method

**Raison :**
- Confidentialité recherches
- Contrôle d'accès granulaire
- Traçabilité téléchargements

**Impact :**
- Pas de symlink public
- Middleware auth + policy sur route download

---

## 11. Événements : Capacité Illimitée ?

### Conflit
Tous les événements ont-ils une capacité max ?

### Décision (ADR-011)
**Choix :** Capacité optionnelle (nullable)

**Logique :**
- Si `capacity` null : inscriptions illimitées
- Si `capacity` défini : vérifier avant RSVP

**Raison :**
- Certains événements (séminaires en ligne) sans limite
- Autres (workshops physiques) limités par salle

**Impact :**
- Colonne `capacity INT NULL` dans table events
- Validation conditionnelle dans EventService

---

## 12. Rôle "Guest" : Utilité ?

### Conflit
Pourquoi un rôle "guest" authentifié alors qu'on a déjà les non-authentifiés ?

### Décision (ADR-012)
**Choix :** Guest = utilisateur authentifié avec accès lecture seule très limité

**Cas d'usage :**
- Visiteurs externes (partenaires)
- Anciens membres (accès archivé)
- Observateurs temporaires

**Permissions Guest :**
- Voir équipements (pas détails sensibles)
- Voir événements publics
- PAS de réservations
- PAS de projets

**Alternative considérée :**
- Supprimer guest : rejetée (peut être utile)

---

## 13. Format Téléphone : Algérie Uniquement ?

### Conflit
Regex `^\+213[0-9]{9}$` limite à l'Algérie, collaboration internationale ?

### Décision (ADR-013)
**Choix :** Téléphone optionnel, regex Algérie par défaut mais pas strictement requis

**Validation :**
```php
phone: nullable | regex:/^\+213[0-9]{9}$/
```

**Raison :**
- Contexte algérien primaire
- Champ nullable permet omission si international
- Facilement modifiable si besoin

**Alternative future :**
- Utiliser package libphonenumber-for-php pour validation internationale

---

## 14. AJAX vs Full Page Reload

### Conflit
Quelles opérations en AJAX, lesquelles en page reload ?

### Décision (ADR-014)
**Choix :** Équilibre pragmatique

**AJAX pour :**
- Recherche équipements (live search)
- Vérification disponibilité réservation
- Notifications unread count
- Filtres dynamiques (matériaux, réservations)
- Calendrier événements/réservations

**Page Reload pour :**
- Création/modification ressources (formulaires standards)
- Authentification (login, logout)
- Navigation principale

**Raison :**
- AJAX améliore UX pour actions fréquentes/rapides
- Page reload acceptable pour actions CRUD classiques
- Simplicité développement/maintenance

**Impact :**
- Alpine.js / Axios pour AJAX
- Controllers retournent JSON pour endpoints AJAX
- Blade classique pour pages CRUD

---

## 15. Tests : Niveau de Couverture ?

### Conflit
Quelle couverture tests requise pour MVP ?

### Décision (ADR-015)
**Choix :** Tests critiques MVP, couverture complète V2

**MVP :**
- Tests feature : auth, réservations (création, validation), disponibilité
- Tests unit : ReservationService, conflict detection
- Pas de tests browser (Dusk) MVP

**V1/V2 :**
- Étendre couverture tous modules
- Browser tests parcours critiques
- Viser 80%+ couverture

**Raison :**
- Équilibre vitesse/qualité MVP
- Focus sur logique métier critique (réservations)

---

## Résumé Décisions Clés

| ADR | Sujet | Décision |
|-----|-------|----------|
| 001 | Architecture | Web Only (pas d'API mobile) |
| 002 | Paiements | Aucun système de paiement |
| 003 | Validation réservations | Manuelle (material_manager) |
| 004 | Notifications | Email + DB (pas WebSockets) |
| 005 | Langue | Multilingue ar/fr/en |
| 006 | Rôles | 7 rôles distincts |
| 007 | Durée réservation | Max 30 jours (configurable) |
| 008 | Conflits réservations | Détection dynamique stricte |
| 009 | Maintenance vs réservations | Annulation auto + notif |
| 010 | Stockage fichiers | Privé, accès contrôlé |
| 011 | Capacité événements | Optionnelle (nullable) |
| 012 | Rôle Guest | Lecture seule limitée |
| 013 | Format téléphone | +213 recommandé, nullable |
| 014 | AJAX vs Reload | Équilibre pragmatique |
| 015 | Couverture tests | Critiques MVP, complet V2 |

---

## Prochaines étapes

- Consulter **GAPS-TODO.md** pour infos manquantes à clarifier
- Voir **99-References.md** pour ressources externes
