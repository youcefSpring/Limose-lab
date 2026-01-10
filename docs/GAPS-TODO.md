# GAPS-TODO.md

## Informations Manquantes et Points à Clarifier

Ce document liste toutes les informations manquantes dans le cahier des charges initial et propose des patchs/décisions par défaut.

---

## 🟢 GAP RÉSOLU (décisions prises dans 13-Conflict.md)

### ✓ GAP-001: Architecture (Web vs API+Apps)
**Manque :** Pas de mention explicite d'applications mobiles
**Décision prise :** Web Only (ADR-001)
**Status :** ✅ RÉSOLU

### ✓ GAP-002: Système de Paiement
**Manque :** Aucune mention paiements/abonnements
**Décision prise :** Pas de module paiement (ADR-002)
**Status :** ✅ RÉSOLU

### ✓ GAP-003: Validation Réservations
**Manque :** Auto-approval ou validation manuelle ?
**Décision prise :** Validation manuelle par material_manager (ADR-003)
**Status :** ✅ RÉSOLU

### ✓ GAP-004: Notifications Temps Réel
**Manque :** WebSockets ou Email seulement ?
**Décision prise :** Email + DB, pas de WebSockets (ADR-004)
**Status :** ✅ RÉSOLU

### ✓ GAP-005: Langue par Défaut
**Manque :** Quelle langue prioritaire ?
**Décision prise :** Multilingue ar/fr/en, défaut configurable (ADR-005)
**Status :** ✅ RÉSOLU

### ✓ GAP-006: Durée Max Réservation
**Manque :** Limite durée réservation ?
**Décision prise :** 30 jours max, configurable (ADR-007)
**Status :** ✅ RÉSOLU

---

## 🟡 GAP À CLARIFIER (besoin input utilisateur)

### ⚠️ GAP-007: Notification Préférences Utilisateurs
**Manque :** Utilisateurs peuvent-ils désactiver certaines notifications ?

**Question :**
Les utilisateurs doivent-ils pouvoir configurer leurs préférences de notifications (email on/off par type) ?

**Proposition Patch :**
```
Option A (Simple) : Toutes notifications activées, pas de config
Option B (Flexible) : Table notification_preferences avec toggle par type
```

**Recommandation :** Option A pour MVP, Option B pour V2

**Impact :**
- Option A : Aucune table supplémentaire
- Option B : Migration + UI préférences profil

**Priorité :** Basse (peut attendre V2)

---

### ⚠️ GAP-008: Réservations Récurrentes
**Manque :** Support réservations récurrentes (ex: tous les lundis) ?

**Question :**
Un utilisateur peut-il créer une réservation récurrente (hebdomadaire, mensuelle) ?

**Proposition Patch :**
```
Option A (MVP) : Pas de récurrence, réservations unitaires seulement
Option B (V2) : Ajout colonne recurrence_pattern, génération auto réservations
```

**Recommandation :** Option A pour MVP

**Impact :**
- Option A : Fonctionnalité actuelle suffisante
- Option B : Complexité algorithme génération + UI

**Priorité :** Basse (nice-to-have V2)

---

### ⚠️ GAP-009: Équipements Composites
**Manque :** Certains équipements sont-ils composés de sous-équipements ?

**Question :**
Faut-il gérer des équipements composites (ex: "Station de travail" = PC + écran + clavier) ?

**Proposition Patch :**
```
Option A (Simple) : Chaque équipement indépendant
Option B (Complexe) : Relation parent-child materials
```

**Recommandation :** Option A pour MVP/V1/V2

**Impact :**
- Option A : Structure actuelle OK
- Option B : Auto-join `parent_id`, logique réservation complexe

**Priorité :** Basse (probablement pas nécessaire)

---

### ⚠️ GAP-010: Hiérarchie Projets (Sous-projets)
**Manque :** Projets peuvent-ils avoir des sous-projets ?

**Question :**
Faut-il supporter une hiérarchie de projets (projet parent → sous-projets) ?

**Proposition Patch :**
```
Option A : Projets plats (tous au même niveau)
Option B : Colonne parent_project_id pour hiérarchie
```

**Recommandation :** Option A pour MVP/V1

**Impact :**
- Option A : Simplicité
- Option B : UI arborescente, permissions héritées

**Priorité :** Basse

---

### ⚠️ GAP-011: Budget Projets
**Manque :** Projets ont-ils un budget à tracker ?

**Question :**
Faut-il gérer budget par projet (montant alloué, dépensé) ?

**Proposition Patch :**
```
Option A : Pas de gestion budget
Option B : Colonnes budget_allocated, budget_spent dans projects
```

**Recommandation :** Option A pour MVP, réévaluer V2 selon retours

**Impact :**
- Option A : Aucun
- Option B : Migration + UI saisie/affichage + rapports financiers

**Priorité :** Moyenne (dépend contexte labo)

---

### ⚠️ GAP-012: Publications Scientifiques
**Manque :** Tracking publications issues de projets ?

**Question :**
Faut-il lier publications scientifiques aux projets (DOI, titre, journal, date) ?

**Proposition Patch :**
```
Option A : Utiliser "Experiments" avec type "publication"
Option B : Table dédiée publications (id, project_id, doi, title, journal, date)
```

**Recommandation :** Option A suffit pour MVP/V1

**Impact :**
- Option A : Fonctionnalité existante
- Option B : CRUD supplémentaire

**Priorité :** Basse

---

### ⚠️ GAP-013: Équipements Consommables
**Manque :** Distinction équipements durables vs consommables ?

**Question :**
Certains matériaux sont-ils consommables (quantité décrémente à usage) vs équipements réutilisables ?

**Proposition Patch :**
```
Option A : Tous matériaux gérés comme réservables (quantité fixe)
Option B : Colonne is_consumable, décrémentation stock à usage
```

**Recommandation :** Option A pour MVP (tous réservables)

**Impact :**
- Option A : Logique actuelle OK
- Option B : Workflow différent (achat vs réservation), gestion stock

**Priorité :** Moyenne (dépend inventaire labo)

---

### ⚠️ GAP-014: QR Codes Équipements
**Manque :** Étiquettes QR codes pour scan rapide ?

**Question :**
Faut-il générer QR codes par équipement (pour scan mobile → détails/réservation) ?

**Proposition Patch :**
```
Option A : Pas de QR codes MVP/V1
Option B (V2) : Génération QR code à la création, route /materials/qr/{id}
```

**Recommandation :** Option B pour V2 (nice-to-have)

**Impact :**
- Option A : Aucun
- Option B : Package QR code generator, impression étiquettes

**Priorité :** Basse (amélioration UX future)

---

### ⚠️ GAP-015: Intégration Calendrier Externe
**Manque :** Export iCal/Google Calendar ?

**Question :**
Utilisateurs peuvent-ils exporter réservations vers calendrier externe (Google, Outlook) ?

**Proposition Patch :**
```
Option A : Pas d'export calendrier externe
Option B : Génération fichier .ics pour réservations/événements
```

**Recommandation :** Option B pour V2 (utile)

**Impact :**
- Option A : Aucun
- Option B : Package iCal generator, endpoint download

**Priorité :** Moyenne (bonne UX)

---

### ⚠️ GAP-016: Niveau Urgence Maintenance
**Manque :** Priorisation maintenances (urgent, normal, bas) ?

**Question :**
Faut-il un niveau d'urgence pour logs maintenance ?

**Proposition Patch :**
```
Option A : Pas de priorité, ordre chronologique
Option B : Colonne priority (low, normal, high, urgent)
```

**Recommandation :** Option B simple à ajouter

**Impact :**
- Option A : Logique actuelle OK
- Option B : Migration + tri par priorité

**Priorité :** Basse (amélioration V2)

---

### ⚠️ GAP-017: Signature Électronique Documents
**Manque :** Validation formelle soumissions (signature) ?

**Question :**
Les soumissions d'expériences nécessitent-elles signature électronique (PI, chef labo) ?

**Proposition Patch :**
```
Option A : Pas de signature (simple upload)
Option B : Workflow approbation avec signature (DocuSign-like)
```

**Recommandation :** Option A pour MVP/V1/V2 (over-engineering)

**Impact :**
- Option A : Fonctionnalité actuelle OK
- Option B : Système signatures complexe

**Priorité :** Très Basse (probablement inutile)

---

### ⚠️ GAP-018: API Externe (Future)
**Manque :** Besoins intégration systèmes tiers ?

**Question :**
Le système devra-t-il exposer API REST pour intégration (LIMS, ERP, etc.) ?

**Proposition Patch :**
```
Option A : Pas d'API externe pour l'instant (Web only)
Option B : Développer API REST Laravel Sanctum token-based
```

**Recommandation :** Option A pour MVP/V1/V2, réévaluer post-lancement

**Impact :**
- Option A : Architecture actuelle
- Option B : Routes API, auth API, documentation Swagger

**Priorité :** Basse (besoin futur potentiel)

---

### ⚠️ GAP-019: Mode Offline Partiel
**Manque :** Fonctionnalités offline (PWA) ?

**Question :**
Doit-on supporter mode offline (consultation équipements, réservations) ?

**Proposition Patch :**
```
Option A : Pas d'offline (web standard, connexion requise)
Option B : PWA avec Service Worker, cache données
```

**Recommandation :** Option A pour MVP/V1/V2

**Impact :**
- Option A : Aucun
- Option B : Manifest.json, Service Worker, stratégie cache

**Priorité :** Très Basse (web app OK)

---

### ⚠️ GAP-020: Alertes Stock Bas (Consommables)
**Manque :** Notifications stock bas ?

**Question :**
Si gestion consommables (GAP-013), alertes quand quantité < seuil ?

**Proposition Patch :**
```
Dépend résolution GAP-013
Si consommables : Colonne min_stock, alert si quantity < min_stock
```

**Recommandation :** À traiter avec GAP-013

**Priorité :** Moyenne (si consommables)

---

## 🔵 GAP MINEUR (précisions souhaitables mais non bloquantes)

### ℹ️ GAP-021: Logo & Branding Labo
**Manque :** Logo laboratoire, couleurs brand

**Action :**
- Demander logo (.png, .svg)
- Palette couleurs (primaire, secondaire)
- Nom complet laboratoire

**Workaround MVP :**
- Logo placeholder
- Couleurs Tailwind par défaut (blue, gray)

**Priorité :** Basse (cosmétique)

---

### ℹ️ GAP-022: Emails Templates Design
**Manque :** Charte graphique emails

**Action :**
- Templates emails basiques Laravel (texte)
- Améliorer design V1 avec layouts HTML

**Priorité :** Basse (fonctionnel > design)

---

### ℹ️ GAP-023: Règles Métier Spécifiques Labo
**Manque :** Règles business particulières non mentionnées

**Exemples possibles :**
- Chercheur senior priorité réservations ?
- Certains équipements réservés catégories utilisateurs ?
- Limitations horaires (pas réservation nuit/weekend) ?

**Action :**
Clarifier avec chef de laboratoire avant V1

**Priorité :** Moyenne (peut impacter logique métier)

---

### ℹ️ GAP-024: Politique Annulation Réservations
**Manque :** Délai minimum annulation ?

**Question :**
Peut-on annuler réservation 1h avant ? Ou délai 24h minimum ?

**Proposition Patch :**
```
Option A : Annulation jusqu'à start_date (pas de délai)
Option B : Délai configurable (ex: 24h avant)
```

**Recommandation :** Option A pour simplicité MVP

**Impact :**
- Option A : Logique actuelle
- Option B : Validation supplémentaire

**Priorité :** Basse

---

### ℹ️ GAP-025: Historique Modifications (Audit Trail)
**Manque :** Traçabilité complète changements ?

**Question :**
Faut-il logger toutes modifications (qui, quand, quoi changé) ?

**Proposition Patch :**
```
Option A : Activity log basique (actions principales)
Option B : Audit complet (Spatie Activity Log sur tous models)
```

**Recommandation :** Option A pour MVP, Option B V2

**Priorité :** Moyenne (utile admin)

---

## 📊 Résumé Priorités

### 🔴 HAUTE (bloquer MVP si non résolu)
- Aucun (tous gaps résolus ou contournables)

### 🟠 MOYENNE (clarifier avant V1)
- GAP-011 : Budget projets
- GAP-013 : Équipements consommables
- GAP-015 : Export calendrier
- GAP-023 : Règles métier spécifiques
- GAP-025 : Audit trail

### 🟢 BASSE (V2 ou post-lancement)
- GAP-007 : Préférences notifications
- GAP-008 : Réservations récurrentes
- GAP-009 : Équipements composites
- GAP-010 : Hiérarchie projets
- GAP-012 : Publications scientifiques
- GAP-014 : QR codes
- GAP-016 : Priorité maintenance
- GAP-017 : Signature électronique
- GAP-018 : API externe
- GAP-019 : Mode offline
- GAP-020 : Alertes stock bas
- GAP-021 : Logo/branding
- GAP-022 : Design emails
- GAP-024 : Politique annulation

---

## 🎯 Actions Recommandées

### Avant de commencer développement :
1. ✅ Lire tous documents générés (00-99, web-*)
2. ⚠️ Clarifier GAPs priorité MOYENNE avec chef labo
3. ✅ Valider décisions ADR (13-Conflict.md)

### Pendant développement MVP :
1. Implémenter selon spécifications
2. Utiliser propositions "Option A" pour gaps non résolus
3. Logger décisions dans ce fichier

### Après MVP (retours utilisateurs) :
1. Réévaluer gaps basse priorité
2. Prioriser V1/V2 selon feedback
3. Mettre à jour documentation

---

## 📝 Template Résolution Gap

Quand un gap est résolu :

```markdown
### ✅ GAP-XXX: Titre
**Résolu le :** YYYY-MM-DD
**Résolution :** Description décision
**Patch appliqué :** Option choisie
**Migration :** [Si applicable] Nom migration
**Status :** ✅ RÉSOLU
```

---

## Prochaines étapes

- Consulter **13-Conflict.md** pour décisions prises (ADR)
- Lire **00-Starter.md** pour démarrer
- Suivre **12-Usage-Guide.md** pour installation
