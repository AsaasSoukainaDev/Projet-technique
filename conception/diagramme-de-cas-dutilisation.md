# Diagramme de cas d'utilisation — Salle de sport

## 🎭 Acteurs

| Acteur | Description |
|--------|-------------|
| 👤 **Visiteur** | Personne non connectée, consulte le catalogue |
| 🏋️ **Adhérent** | Utilisateur inscrit, réserve des séances |
| 🧑‍🏫 **Coach** | Anime les séances, consulte son planning |
| 👑 **Administrateur** | Gère coachs, disciplines et séances |

## 🔗 Diagramme

```mermaid
graph TB
    subgraph Acteurs["🎭 Acteurs"]
        V[👤 Visiteur]
        AD[🏋️ Adhérent]
        CO[🧑‍🏫 Coach]
        ADMIN[👑 Administrateur]
    end

    subgraph Système["🖥️ Système de gestion de salle de sport"]
        UC1["Consulter le catalogue des séances"]
        UC2["Rechercher une séance"]
        UC3["Filtrer par discipline"]
        UC4["Voir le détail d'une séance"]
        UC5["S'inscrire / S'authentifier"]
        UC6["Réserver une séance"]
        UC7["Annuler une réservation"]
        UC8["Consulter son planning"]
        UC9["Gérer son profil"]
        UC10["Consulter ses séances animées"]
        UC11["Gérer les coachs"]
        UC12["Gérer les disciplines"]
        UC13["Gérer les séances"]
        UC14["Suivre les réservations"]
    end

    V --> UC1
    V --> UC2
    V --> UC3
    V --> UC4

    AD --> UC5
    AD --> UC6
    AD --> UC7
    AD --> UC8
    AD --> UC9

    CO --> UC10
    CO --> UC9

    ADMIN --> UC11
    ADMIN --> UC12
    ADMIN --> UC13
    ADMIN --> UC14

    UC6 -.->|include| UC5
    UC7 -.->|include| UC5
    UC8 -.->|include| UC5
    UC10 -.->|include| UC5

    AD -.->|hérite| V
    CO -.->|hérite| AD
    ADMIN -.->|hérite| CO

    style V fill:#e0f2fe,stroke:#0284c7,color:#0c4a6e
    style AD fill:#dbeafe,stroke:#2563eb,color:#1e3a8a
    style CO fill:#fef9c3,stroke:#ca8a04,color:#713f12
    style ADMIN fill:#fce7f3,stroke:#db2777,color:#831843
```