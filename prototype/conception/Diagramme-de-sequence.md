sequenceDiagram
    autonumber
    actor Coach as 🏋️ Coach
    participant UI as 🖥️ FormulaireSeance
    participant Ctrl as 🎛️ SeanceController
    participant Service as ⚙️ SeanceService
    participant DAO as 💾 SeanceDAO
    database DB as 🗄️ Base de données

    Note over Coach,DB: Scénario : Ajouter une nouvelle séance

    Coach->>UI: cliquer sur "Ajouter une séance"
    activate UI
    UI->>Ctrl: demanderFormulaire()
    activate Ctrl
    Ctrl-->>UI: formulaireVide()
    deactivate Ctrl
    UI-->>Coach: afficher le formulaire
    deactivate UI

    Coach->>UI: saisir(titre, date_seance, heure_debut, duree_minutes, niveau, nb_places, prix, discipline)
    Coach->>UI: cliquer sur "Enregistrer"
    activate UI
    UI->>Ctrl: enregistrerSeance(donnees)
    activate Ctrl

    Ctrl->>Service: validerSeance(donnees)
    activate Service
    alt Données invalides
        Service-->>Ctrl: erreurs["titre vide", "date manquante", "prix invalide"]
        Ctrl-->>UI: afficherErreurs(erreurs)
        UI-->>Coach: ❌ message d'erreur
    else Données valides
        Service-->>Ctrl: donneesValides = true
    end
    deactivate Service

    Ctrl->>Service: verifierCoach(idCoach)
    activate Service
    Service->>DAO: trouverCoachParId(idCoach)
    activate DAO
    DAO->>DB: SELECT * FROM coach WHERE id_coach = ?
    activate DB
    DB-->>DAO: resultat
    deactivate DB
    DAO-->>Service: coach
    deactivate DAO
    Service-->>Ctrl: coachExiste = true
    deactivate Service

    Ctrl->>Service: verifierDiscipline(idDiscipline)
    activate Service
    Service->>DAO: trouverDisciplineParId(idDiscipline)
    activate DAO
    DAO->>DB: SELECT * FROM discipline WHERE id_discipline = ?
    activate DB
    DB-->>DAO: resultat
    deactivate DB
    DAO-->>Service: discipline
    deactivate DAO
    Service-->>Ctrl: disciplineExiste = true
    deactivate Service

    Ctrl->>Service: verifierConflitHoraire(idCoach, date_seance, heure_debut, duree_minutes)
    activate Service
    Service->>DAO: rechercherSeanceConflit(idCoach, date_seance, heure_debut)
    activate DAO
    DAO->>DB: SELECT * FROM seance WHERE id_coach = ? AND date_seance = ? AND heure_debut = ?
    activate DB
    DB-->>DAO: resultat
    deactivate DB
    DAO-->>Service: conflit
    deactivate DAO
    alt Conflit horaire détecté
        Service-->>Ctrl: conflitExiste = true
        Ctrl-->>UI: afficherErreurs(["Conflit horaire : vous avez déjà une séance sur ce créneau"])
        UI-->>Coach: ❌ message d'erreur
    else Pas de conflit
        Service-->>Ctrl: conflitExiste = false
    end
    deactivate Service

    Ctrl->>Service: creerSeance(donnees)
    activate Service
    Service->>Service: new Seance(...)
    Service->>Service: setActif(true)
    Service->>Service: setIdCoach(idCoach)
    Service->>DAO: sauvegarder(seance)
    activate DAO
    DAO->>DB: INSERT INTO seance (titre, date_seance, heure_debut, duree_minutes, niveau, nb_places, prix, actif, id_coach, id_discipline) VALUES (...)
    activate DB
    DB-->>DAO: idGenere
    deactivate DB
    DAO-->>Service: seanceSauvegardee
    deactivate DAO
    Service-->>Ctrl: seanceCreee(id_seance)
    deactivate Service

    Ctrl-->>UI: afficherConfirmation(seance)
    deactivate Ctrl
    UI-->>Coach: ✅ "Séance ajoutée avec succès !"
    deactivate UI

    Note over Coach,DB: Mise à jour du planning

    Coach->>UI: consulter son planning
    activate UI
    UI->>Ctrl: obtenirSeancesParCoach(idCoach)
    activate Ctrl
    Ctrl->>Service: listerSeancesParCoach(idCoach)
    activate Service
    Service->>DAO: findByCoach(idCoach)
    activate DAO
    DAO->>DB: SELECT * FROM seance WHERE id_coach = ? ORDER BY date_seance
    activate DB
    DB-->>DAO: liste
    deactivate DB
    DAO-->>Service: liste
    deactivate DAO
    Service-->>Ctrl: liste
    deactivate Service
    Ctrl-->>UI: liste
    deactivate Ctrl
    UI-->>Coach: afficher le planning à jour
    deactivate UI