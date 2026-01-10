# web-user-stories.md

## User Stories Spécifiques Application Web RLMS

Stories centrées sur l'expérience utilisateur web, interactions UI, et fonctionnalités spécifiques au navigateur.

---

## Interface & Navigation

### WEB-001: Navigation Responsive
**En tant qu'** utilisateur mobile
**Je veux** une navigation adaptée à mon écran
**Afin de** naviguer facilement sur smartphone

**Critères d'acceptation :**
- Menu hamburger sur mobile
- Navigation collapse/expand
- Touch-friendly (boutons min 44x44px)
- Swipe gestures sur modals
- Landscape/portrait adaptatif

**MVP**

---

### WEB-002: Changement Langue Dynamique
**En tant qu'** utilisateur
**Je veux** changer la langue via un sélecteur
**Afin d'** utiliser l'interface dans ma langue préférée

**Critères d'acceptation :**
- Dropdown langue (ar, fr, en) dans navigation
- Application immédiate sans rechargement page
- Icône drapeau par langue
- Support RTL automatique pour arabe
- Sauvegarde préférence en DB

**MVP**

---

### WEB-003: Breadcrumb Navigation
**En tant qu'** utilisateur
**Je veux** voir un fil d'Ariane
**Afin de** savoir où je suis et naviguer rapidement

**Critères d'acceptation :**
- Breadcrumb sur toutes pages internes
- Format : Dashboard > Matériel > Microscopes > Détails
- Liens cliquables sauf page courante
- Responsive (collapse sur mobile)

**V1**

---

## Recherche & Filtres

### WEB-004: Recherche Live Équipements
**En tant qu'** utilisateur
**Je veux** rechercher des équipements en temps réel
**Afin de** trouver rapidement ce que je cherche

**Critères d'acceptation :**
- Input search avec icône loupe
- AJAX request à chaque frappe (debounce 300ms)
- Résultats mis à jour sans rechargement
- Highlight terme recherché dans résultats
- Loader pendant recherche
- Message "Aucun résultat" si vide

**MVP**

---

### WEB-005: Filtres Multiples Matériel
**En tant qu'** utilisateur
**Je veux** combiner plusieurs filtres
**Afin de** affiner ma recherche

**Critères d'acceptation :**
- Filtres : Catégorie, Statut, Localisation
- Checkboxes multiples
- Application AJAX en temps réel
- Badge compteur résultats
- Bouton "Réinitialiser filtres"
- Sauvegarde filtres en session

**V2**

---

## Formulaires & Validation

### WEB-006: Validation Inline Formulaires
**En tant qu'** utilisateur
**Je veux** voir les erreurs de validation immédiatement
**Afin de** corriger rapidement mes erreurs

**Critères d'acceptation :**
- Validation côté client (JavaScript) avant submit
- Validation côté serveur (Laravel)
- Affichage erreurs sous champs concernés
- Icône erreur rouge
- Focus automatique premier champ erreur
- Messages en langue utilisateur

**MVP**

---

### WEB-007: Upload Fichiers avec Prévisualisation
**En tant qu'** utilisateur soumettant expérience
**Je veux** prévisualiser fichiers avant upload
**Afin de** vérifier que ce sont les bons

**Critères d'acceptation :**
- Drag & drop zone
- Clic pour sélectionner fichiers
- Prévisualisation images (thumbnail)
- Nom fichier pour non-images
- Taille fichier affichée
- Bouton supprimer avant upload
- Progress bar pendant upload
- Max 5 fichiers, 10MB chacun

**V1**

---

### WEB-008: Formulaire Multi-étapes Réservation
**En tant qu'** utilisateur
**Je veux** créer une réservation en plusieurs étapes
**Afin de** ne pas être submergé d'informations

**Critères d'acceptation :**
- Étape 1 : Sélection équipement
- Étape 2 : Dates et quantité (avec vérif dispo)
- Étape 3 : Justification et notes
- Étape 4 : Récapitulatif
- Navigation précédent/suivant
- Indicateur progression (1/4, 2/4...)
- Sauvegarde brouillon (optionnel)

**V2**

---

## Calendrier & Planning

### WEB-009: Calendrier Réservations Interactif
**En tant qu'** utilisateur
**Je veux** voir un calendrier des réservations
**Afin de** visualiser les disponibilités

**Critères d'acceptation :**
- Vue mois/semaine/jour
- Réservations affichées comme événements
- Couleur par statut (pending, approved, rejected)
- Clic sur réservation → modal détails
- Filtrer par équipement
- Navigation mois précédent/suivant

**V2 - FullCalendar.js**

---

### WEB-010: Vérification Disponibilité Temps Réel
**En tant qu'** utilisateur créant réservation
**Je veux** voir la disponibilité en temps réel
**Afin d'** éviter les conflits

**Critères d'acceptation :**
- AJAX check après sélection dates
- Message vert : "X unités disponibles"
- Message rouge : "Conflit détecté" avec détails
- Liste réservations chevauchantes
- Suggestion dates alternatives (optionnel)
- Désactiver submit si conflit

**MVP**

---

## Notifications & Alertes

### WEB-011: Badge Notifications Non Lues
**En tant qu'** utilisateur
**Je veux** voir un badge du nombre de notifications non lues
**Afin d'** être informé d'activités importantes

**Critères d'acceptation :**
- Badge rouge sur icône cloche
- Compteur notifications non lues
- Polling AJAX toutes les 30 secondes
- Mise à jour compteur sans rechargement
- Clic badge → dropdown notifications
- Animation subtile nouvelle notification

**V1**

---

### WEB-012: Dropdown Notifications Récentes
**En tant qu'** utilisateur
**Je veux** voir mes notifications récentes dans un dropdown
**Afin de** les consulter rapidement

**Critères d'acceptation :**
- Dropdown max 5 notifications récentes
- Titre, extrait, date relative (il y a 2h)
- Icône par type notification
- Clic notification → page détails ressource
- Marquer comme lue au clic
- Lien "Voir toutes" vers page complète

**V1**

---

### WEB-013: Toast Notifications Temporaires
**En tant qu'** utilisateur
**Je veux** voir des notifications toast pour actions
**Afin d'** avoir feedback immédiat

**Critères d'acceptation :**
- Toast coin supérieur droit
- Types : success, error, warning, info
- Auto-dismiss après 5 secondes
- Bouton fermeture manuelle
- Animation slide-in/out
- Max 3 toasts simultanés

**MVP**

---

## Tableaux & Listes

### WEB-014: Tableaux Triables
**En tant qu'** utilisateur consultant listes
**Je veux** trier par colonne
**Afin d'** organiser l'information

**Critères d'acceptation :**
- Clic en-tête colonne pour trier
- Icône flèche haut/bas indique tri
- Tri ascendant/descendant/aucun
- Persistance tri en session
- Tri alphanumérique intelligent

**V1**

---

### WEB-015: Pagination AJAX
**En tant qu'** utilisateur
**Je veux** naviguer entre pages sans rechargement complet
**Afin d'** avoir une expérience fluide

**Critères d'acceptation :**
- Pagination en bas de tableau
- Boutons précédent/suivant
- Numéros pages cliquables
- AJAX load nouvelle page
- Loader pendant chargement
- URL update (history API)

**MVP**

---

### WEB-016: Actions Bulk (Sélection Multiple)
**En tant qu'** administrateur
**Je veux** sélectionner plusieurs éléments pour action groupée
**Afin de** gagner du temps

**Critères d'acceptation :**
- Checkbox par ligne tableau
- Checkbox "Sélectionner tout"
- Badge "X sélectionnés"
- Actions bulk : Approuver, Rejeter, Supprimer
- Confirmation modal avant action
- Feedback résultat (X réussies, Y échouées)

**V2**

---

## Dashboard & Analytics

### WEB-017: Widgets Dashboard Personnalisables
**En tant qu'** utilisateur
**Je veux** personnaliser mon dashboard
**Afin d'** afficher infos pertinentes pour moi

**Critères d'acceptation :**
- Widgets drag & drop repositionnables
- Afficher/masquer widgets
- Widgets disponibles : Mes réservations, Notifications, Projets, Stats
- Sauvegarde layout en DB
- Bouton "Réinitialiser layout"

**V2**

---

### WEB-018: Graphiques Interactifs Rapports
**En tant qu'** utilisateur consultant rapports
**Je veux** des graphiques interactifs
**Afin de** mieux comprendre les données

**Critères d'acceptation :**
- Chart.js pour graphiques
- Types : Line, Bar, Pie, Doughnut
- Hover affiche détails point
- Légende cliquable (hide/show série)
- Responsive (adapté mobile)
- Export image graphique (optionnel)

**V2**

---

## Collaboration & Temps Réel

### WEB-019: Commentaires Imbriqués (Thread)
**En tant que** membre projet
**Je veux** répondre à des commentaires
**Afin de** structurer discussions

**Critères d'acceptation :**
- Bouton "Répondre" sous chaque commentaire
- Affichage imbriqué (max 2 niveaux)
- Indentation visuelle
- Collapse/expand threads longs
- Compteur réponses

**V1**

---

### WEB-020: Mentions Utilisateurs (@user)
**En tant qu'** utilisateur commentant
**Je veux** mentionner d'autres utilisateurs
**Afin de** les notifier directement

**Critères d'acceptation :**
- Saisie @nom déclenche autocomplete
- Liste membres projet filtrée
- Sélection insert @username
- Notification utilisateur mentionné
- Lien cliquable vers profil

**V2**

---

## Accessibilité & UX

### WEB-021: Mode Sombre (Dark Mode)
**En tant qu'** utilisateur
**Je veux** activer un thème sombre
**Afin de** réduire fatigue oculaire

**Critères d'acceptation :**
- Toggle switch mode clair/sombre
- Sauvegarde préférence en DB
- Application instantanée (CSS variables)
- Toutes pages supportées
- Contraste suffisant (WCAG AA)

**V2**

---

### WEB-022: Raccourcis Clavier
**En tant qu'** utilisateur avancé
**Je veux** des raccourcis clavier
**Afin de** naviguer plus rapidement

**Critères d'acceptation :**
- Liste raccourcis : Ctrl+K (search), G+D (dashboard), G+M (materials), etc.
- Modal aide (?) affiche raccourcis
- Fonctionnels sur toutes pages
- Non conflit avec navigateur

**V2**

---

### WEB-023: Messages Confirmation Actions Critiques
**En tant qu'** utilisateur
**Je veux** confirmation avant actions destructives
**Afin d'** éviter erreurs

**Critères d'acceptation :**
- Modal confirmation pour : Supprimer, Bannir, Annuler réservation
- Message clair conséquences
- Boutons contrastés (Confirmer danger, Annuler neutre)
- Focus automatique bouton Annuler
- Échap ferme modal

**MVP**

---

## Performance & Offline

### WEB-024: Lazy Loading Images
**En tant qu'** utilisateur consultant catalogues
**Je veux** que les images se chargent progressivement
**Afin d'** avoir page rapide

**Critères d'acceptation :**
- Images chargées au scroll
- Placeholder flou pendant chargement
- Native lazy loading (loading="lazy")
- Fallback JS si non supporté

**V1**

---

### WEB-025: État Loading Explicite
**En tant qu'** utilisateur
**Je veux** voir clairement quand système charge
**Afin de** ne pas cliquer plusieurs fois

**Critères d'acceptation :**
- Spinner pendant requêtes AJAX
- Boutons désactivés + spinner pendant submit
- Skeleton screens pour listes (optionnel)
- Timeout 30s avec message erreur

**MVP**

---

## Export & Impression

### WEB-026: Export PDF Rapport
**En tant qu'** administrateur
**Je veux** exporter rapports en PDF
**Afin de** les partager ou archiver

**Critères d'acceptation :**
- Bouton "Exporter PDF" sur pages rapports
- Génération asynchrone (queue job)
- Notification quand prêt + lien download
- PDF formaté proprement (logo, en-tête, footer)
- Graphiques inclus

**V2**

---

### WEB-027: Export Excel Données
**En tant qu'** administrateur
**Je veux** exporter données en Excel
**Afin de** analyser dans tableur

**Critères d'acceptation :**
- Bouton "Exporter Excel" sur tableaux
- Format .xlsx
- En-têtes colonnes traduits
- Filtres appliqués respectés
- Max 10000 lignes (limite raisonnable)

**V2**

---

### WEB-028: Vue Impression Optimisée
**En tant qu'** utilisateur
**Je veux** imprimer pages proprement
**Afin d'** avoir documents lisibles

**Critères d'acceptation :**
- CSS print media queries
- Masquer navigation, footer, sidebar
- Pagination intelligente (pas de coupure milieu tableau)
- QR code vers page web (optionnel)

**V2**

---

## Administration

### WEB-029: Dashboard Admin Vue d'Ensemble
**En tant qu'** administrateur
**Je veux** un dashboard global
**Afin de** monitorer système

**Critères d'acceptation :**
- KPIs clés : Users pending, Réservations pending, Équipements maintenance
- Graphique activité 30 derniers jours
- Liste dernières actions (activity log)
- Alertes système (erreurs, problèmes)
- Liens rapides actions admin

**MVP**

---

### WEB-030: Gestion Utilisateurs Tableau Avancé
**En tant qu'** administrateur
**Je veux** gérer utilisateurs efficacement
**Afin de** maintenir qualité base utilisateurs

**Critères d'acceptation :**
- Tableau tous utilisateurs paginé
- Filtres : Status, Rôle, Date inscription
- Recherche par nom/email
- Actions inline : Approuver, Suspendre, Éditer, Voir profil
- Badge visuel par statut
- Export liste Excel

**V1**

---

## Résumé Priorités

### MVP (Critique)
- WEB-002, WEB-004, WEB-006, WEB-010, WEB-015, WEB-023, WEB-025, WEB-029

### V1 (Important)
- WEB-001, WEB-011, WEB-012, WEB-013, WEB-014, WEB-019, WEB-024, WEB-030

### V2 (Nice-to-have)
- WEB-003, WEB-005, WEB-008, WEB-009, WEB-016, WEB-017, WEB-018, WEB-020, WEB-021, WEB-022, WEB-026, WEB-027, WEB-028

---

## Prochaines étapes

- Consulter **10-Module.md** et **web-module.md** pour implémentation technique
- Voir **12-Usage-Guide.md** pour démarrage développement
- Référencer **GAPS-TODO.md** pour clarifications nécessaires
