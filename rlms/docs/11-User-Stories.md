# 11-User-Stories.md

## User Stories Transversales du Système RLMS

---

## MVP - Phase 1

### US-001: Inscription et Authentification
**En tant que** chercheur
**Je veux** créer un compte et me connecter
**Afin d'** accéder au système de gestion du laboratoire

**Critères d'acceptation :**
- Formulaire inscription avec validation
- Email unique
- Mot de passe min 8 caractères
- Compte en statut "pending" après inscription
- Email de confirmation envoyé
- Redirection vers dashboard après connexion

**MVP**

---

### US-002: Approbation Utilisateur
**En tant qu'** administrateur
**Je veux** approuver les inscriptions et assigner des rôles
**Afin de** contrôler l'accès au système

**Critères d'acceptation :**
- Liste utilisateurs en attente
- Pouvoir assigner un rôle lors de l'approbation
- Notification email à l'utilisateur approuvé
- Utilisateur peut se connecter après approbation

**MVP**

---

### US-003: Consulter Équipements Disponibles
**En tant qu'** utilisateur authentifié
**Je veux** consulter la liste des équipements disponibles
**Afin de** connaître le matériel que je peux réserver

**Critères d'acceptation :**
- Liste paginée des équipements
- Filtres par catégorie, statut, disponibilité
- Recherche par nom AJAX
- Affichage quantité disponible
- Vue détails équipement

**MVP**

---

### US-004: Créer une Réservation
**En tant que** chercheur
**Je veux** réserver un équipement pour une période donnée
**Afin de** planifier mon travail de recherche

**Critères d'acceptation :**
- Sélection équipement, dates début/fin, quantité
- Validation disponibilité en temps réel
- Détection conflits de réservation
- Message d'erreur si conflit
- Statut "pending" après création
- Notification email envoyée au material manager

**MVP**

---

### US-005: Valider Réservation
**En tant que** material manager
**Je veux** approuver ou rejeter les demandes de réservation
**Afin de** gérer efficacement l'utilisation des équipements

**Critères d'acceptation :**
- Liste réservations pending
- Boutons Approuver/Rejeter
- Champ motif de refus si rejet
- Notification email au demandeur
- Mise à jour statut réservation

**MVP**

---

### US-006: Tableau de Bord Personnel
**En tant qu'** utilisateur authentifié
**Je veux** voir un dashboard personnalisé
**Afin de** suivre rapidement mes activités

**Critères d'acceptation :**
- Mes réservations en cours
- Mes réservations à venir
- Notifications récentes
- Statistiques personnelles
- Liens rapides vers actions courantes

**MVP**

---

## V1 - Phase 2

### US-007: Créer un Projet
**En tant que** chercheur
**Je veux** créer un projet de recherche
**Afin de** structurer mon travail et collaborer

**Critères d'acceptation :**
- Formulaire création projet
- Assigner membres au projet
- Définir dates début/fin
- Notification membres assignés
- Dashboard projet avec activités

**V1**

---

### US-008: Soumettre Résultats d'Expérience
**En tant que** membre d'un projet
**Je veux** soumettre des résultats d'expérience avec fichiers
**Afin de** partager mes découvertes avec l'équipe

**Critères d'acceptation :**
- Formulaire soumission avec upload fichiers
- Max 5 fichiers, 10MB chacun
- Types autorisés : pdf, doc, xlsx, zip
- Historique soumissions du projet
- Notification autres membres
- Téléchargement fichiers sécurisé

**V1**

---

### US-009: Commenter Soumission
**En tant que** membre d'un projet
**Je veux** commenter les soumissions d'expériences
**Afin de** discuter et collaborer

**Critères d'acceptation :**
- Thread de commentaires par soumission
- Réponses imbriquées (replies)
- Notification auteur soumission
- Édition/suppression propres commentaires

**V1**

---

### US-010: Créer un Événement
**En tant qu'** administrateur
**Je veux** créer des événements et séminaires
**Afin d'** organiser la vie scientifique du labo

**Critères d'acceptation :**
- Formulaire création événement
- Définir date, heure, lieu, capacité
- Type public/privé avec rôles ciblés
- Upload image événement (optionnel)
- Notification utilisateurs ciblés

**V1**

---

### US-011: S'inscrire à un Événement
**En tant qu'** utilisateur authentifié
**Je veux** m'inscrire aux événements
**Afin de** participer aux activités du labo

**Critères d'acceptation :**
- Bouton RSVP sur page événement
- Vérification places disponibles
- Message erreur si complet
- Confirmation inscription
- Email reminder 24h avant événement

**V1**

---

### US-012: Gérer Profil Utilisateur
**En tant qu'** utilisateur authentifié
**Je veux** modifier mon profil
**Afin de** maintenir mes informations à jour

**Critères d'acceptation :**
- Édition nom, email, téléphone, bio
- Upload avatar
- Changement mot de passe sécurisé
- Sélection langue interface (ar/fr/en)
- Validation email unique

**V1**

---

### US-013: Notifications In-App
**En tant qu'** utilisateur authentifié
**Je veux** recevoir des notifications dans l'interface
**Afin d'** être informé en temps réel

**Critères d'acceptation :**
- Badge compteur notifications non lues
- Dropdown liste notifications
- Marquer comme lue
- Marquer toutes comme lues
- Redirection vers ressource concernée

**V1**

---

## V2 - Phase 3

### US-014: Planifier Maintenance
**En tant que** technicien
**Je veux** planifier la maintenance des équipements
**Afin de** assurer leur bon fonctionnement

**Critères d'acceptation :**
- Formulaire création log maintenance
- Sélection équipement, type, date planifiée
- Statut équipement → maintenance automatique
- Annulation réservations futures affectées
- Notification utilisateurs concernés

**V2**

---

### US-015: Terminer Maintenance
**En tant que** technicien
**Je veux** marquer une maintenance comme terminée
**Afin de** rendre l'équipement disponible

**Critères d'acceptation :**
- Bouton "Terminer" sur log maintenance
- Saisie date effective, notes, coût
- Statut équipement → available
- Notification utilisateurs en attente

**V2**

---

### US-016: Voir Calendrier Réservations
**En tant qu'** utilisateur authentifié
**Je veux** voir un calendrier des réservations
**Afin de** visualiser la disponibilité

**Critères d'acceptation :**
- Vue calendrier mensuel/hebdomadaire
- Affichage réservations approved
- Filtrer par équipement
- Clic sur réservation → détails
- Couleurs par statut

**V2**

---

### US-017: Générer Rapport Utilisation
**En tant qu'** administrateur
**Je veux** générer des rapports d'utilisation
**Afin d'** analyser l'activité du labo

**Critères d'acceptation :**
- Sélection période (date range)
- Types : équipements, utilisateurs, réservations
- Graphiques visuels (Chart.js)
- Export PDF/Excel
- Tableaux détaillés

**V2**

---

### US-018: Recherche Avancée Équipements
**En tant qu'** utilisateur authentifié
**Je veux** rechercher des équipements avec filtres avancés
**Afin de** trouver rapidement ce dont j'ai besoin

**Critères d'acceptation :**
- Filtres multiples : catégorie, statut, localisation
- Recherche texte en temps réel (AJAX)
- Tri par nom, disponibilité, date achat
- Résultats paginés
- Sauvegarde filtres (session)

**V2**

---

### US-019: Annuler Réservation
**En tant qu'** utilisateur ayant fait une réservation
**Je veux** pouvoir annuler ma réservation
**Afin de** libérer l'équipement si je n'en ai plus besoin

**Critères d'acceptation :**
- Bouton "Annuler" sur réservation pending ou approved (avant date début)
- Confirmation modal
- Mise à jour statut → cancelled
- Notification material manager
- Équipement redevient disponible

**V2**

---

### US-020: Changer Langue Interface
**En tant qu'** utilisateur
**Je veux** changer la langue de l'interface
**Afin d'** utiliser le système dans ma langue préférée

**Critères d'acceptation :**
- Sélecteur de langue (ar, fr, en)
- Application immédiate du changement
- Support RTL pour arabe
- Sauvegarde préférence en DB
- Toutes pages traduites

**V2**

---

### US-021: Suspendre Utilisateur
**En tant qu'** administrateur
**Je veux** suspendre temporairement un utilisateur
**Afin de** gérer les violations de règles

**Critères d'acceptation :**
- Bouton "Suspendre" sur profil utilisateur
- Saisie durée suspension et motif
- Statut utilisateur → suspended
- Déconnexion immédiate
- Email notification utilisateur
- Réactivation automatique après date

**V2**

---

### US-022: Gérer Catégories Matériel
**En tant qu'** administrateur
**Je veux** créer et gérer des catégories d'équipements
**Afin d'** organiser l'inventaire

**Critères d'acceptation :**
- CRUD catégories
- Nom unique
- Description optionnelle
- Affectation lors création équipement
- Impossible supprimer si équipements associés

**V2**

---

### US-023: Vue Mobile Responsive
**En tant qu'** utilisateur mobile
**Je veux** utiliser le système sur smartphone/tablette
**Afin d'** accéder au labo en déplacement

**Critères d'acceptation :**
- Design responsive Tailwind
- Navigation mobile adaptée
- Formulaires utilisables sur mobile
- Calendriers tactiles
- Performance optimisée

**V2**

---

## Format Alternatif (Given-When-Then)

### US-024: Détection Conflit Réservation
**Given** un équipement avec quantité limitée
**And** une réservation approved pour 2 unités du 01/02 au 05/02
**When** un utilisateur tente de réserver 3 unités du 03/02 au 04/02
**Then** le système affiche un message d'erreur "Quantité insuffisante"
**And** indique la quantité disponible (ex: 0 sur 3)

**V1**

---

## Prochaines étapes

- Consulter **web-user-stories.md** pour stories spécifiques application web
- Voir **10-Module.md** pour implémentation par module
