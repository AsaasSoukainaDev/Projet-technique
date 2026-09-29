
console.log("JavaScript chargé");


// Récupérer les éléments
const btnAjouter = document.getElementById("btnAjouter");

const btnAnnuler = document.getElementById("btnAnnuler");

const formContainer = document.getElementById("formContainer");

const formDiscipline = document.getElementById("formDiscipline");


// Bouton Ajouter
btnAjouter.addEventListener("click", function () {

    console.log("Bouton Ajouter cliqué");

    formContainer.style.display = "block";

});


// Bouton Annuler
btnAnnuler.addEventListener("click", function () {

    formContainer.style.display = "none";

    formDiscipline.reset();

});

