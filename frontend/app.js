
const API_URL = "../backend/api/GestionDiscipline.php";

const btnAjouter = document.getElementById("btnAjouter");
const btnAnnuler = document.getElementById("btnAnnuler");

const formContainer = document.getElementById("formContainer");
const formDiscipline = document.getElementById("formDiscipline");

const tableBody = document.getElementById("tableBody");


// Afficher le formulaire
btnAjouter.addEventListener("click", function () {

    formContainer.style.display = "block";

});



// Annuler
btnAnnuler.addEventListener("click", function () {

    formContainer.style.display = "none";

    formDiscipline.reset();

});


// Afficher les disciplines
function afficherDisciplines() {

    fetch(API_URL)

        .then(response => response.json())

        .then(disciplines => {

            tableBody.innerHTML = "";

            disciplines.forEach(discipline => {

                tableBody.innerHTML += `
                <tr class="border-b border-gray-700 hover:bg-gray-800">
            
                    <td class="px-6 py-4">
                        ${discipline.id_discipline}
                    </td>
            
                    <td class="px-6 py-4 font-semibold">
                        ${discipline.libelle}
                    </td>
            
                    <td class="px-6 py-4 text-gray-400">
                        ${discipline.description}
                    </td>
            
                </tr>
            `;

            });

        });
}


// Ajouter une discipline
formDiscipline.addEventListener("submit", function(event) {

    event.preventDefault();

    const discipline = {

        libelle: document.getElementById("libelle").value,

        description: document.getElementById("description").value

    };


    fetch(API_URL, {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify(discipline)

    })

    .then(() => {

        formDiscipline.reset();

        formContainer.style.display = "none";

        afficherDisciplines();

    });

});


// Afficher au démarrage
afficherDisciplines();






