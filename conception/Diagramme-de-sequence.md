```mermaid
sequenceDiagram
    autonumber
    actor Chef as 👨‍🍳 Chef
    participant UI as 🖥️ FormulaireRecette
    participant Ctrl as 🎛️ RecetteController
    participant Service as ⚙️ RecetteService
    participant DAO as 💾 RecetteDAO
    database DB as 🗄️ Base de données

    Note over Chef,DB: Scénario : Créer une nouvelle recette

    Chef->>UI: cliquer sur "Nouvelle recette"
    activate UI
    UI->>Ctrl: demanderFormulaire()
    activate Ctrl
    Ctrl-->>UI: formulaireVide()
    deactivate Ctrl
    UI-->>Chef: afficher le formulaire
    deactivate UI

    Chef->>UI: saisir(nom, ingredients, instructions, typeCuisine)
    Chef->>UI: cliquer sur "Enregistrer"
    activate UI
    UI->>Ctrl: enregistrerRecette(donnees)
    activate Ctrl

    Ctrl->>Service: validerRecette(donnees)
    activate Service
    alt Données invalides
        Service-->>Ctrl: erreurs["nom vide", "type manquant"]
        Ctrl-->>UI: afficherErreurs(erreurs)
        UI-->>Chef: ❌ message d'erreur
    else Données valides
        Service-->>Ctrl: donneesValides = true
    end
    deactivate Service

    Ctrl->>Service: verifierChef(idChef)
    activate Service
    Service->>DAO: trouverChefParId(idChef)
    activate DAO
    DAO->>DB: SELECT * FROM chef WHERE id = ?
    activate DB
    DB-->>DAO: resultat
    deactivate DB
    DAO-->>Service: chef
    deactivate DAO
    Service-->>Ctrl: chefExiste = true
    deactivate Service

    Ctrl->>Service: creerRecette(donnees)
    activate Service
    Service->>Service: new Recette(...)
    Service->>Service: setDateCreation(now())
    Service->>DAO: sauvegarder(recette)
    activate DAO
    DAO->>DB: INSERT INTO recette (...) VALUES (...)
    activate DB
    DB-->>DAO: idGenere
    deactivate DB
    DAO-->>Service: recetteSauvegardee
    deactivate DAO
    Service-->>Ctrl: recetteCreee(id)
    deactivate Service

    Ctrl-->>UI: afficherConfirmation(recette)
    deactivate Ctrl
    UI-->>Chef: ✅ "Recette enregistrée avec succès !"
    deactivate UI

    Note over Chef,DB: Mise à jour de la liste
    Chef->>UI: consulter la liste
    activate UI
    UI->>Ctrl: obtenirToutesRecettes()
    activate Ctrl
    Ctrl->>Service: listerRecettes()
    activate Service
    Service->>DAO: findAll()
    activate DAO
    DAO->>DB: SELECT * FROM recette
    activate DB
    DB-->>DAO: liste
    deactivate DB
    DAO-->>Service: liste
    deactivate DAO
    Service-->>Ctrl: liste
    deactivate Service
    Ctrl-->>UI: liste
    deactivate Ctrl
    UI-->>Chef: afficher la liste à jour
    deactivate UI
```