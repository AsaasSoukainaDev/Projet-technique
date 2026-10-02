
const API_URL = "../backend/api.php";

const btnAjouter = document.getElementById("btnAjouter");
const btnAnnuler = document.getElementById("btnAnnuler");

const formContainer = document.getElementById("formContainer");
const formDiscipline = document.getElementById("formDiscipline");

const tableBody = document.getElementById("tableBody");

function afficherDisciplines(){
    fetch(API_URL)
    .then(Response=>Response.json())
    .then(disciplines=>{
        tableBody.innerHTML="";
        disciplines.forEach(discipline => {
        tableBody.innerHTML+=`


        <tr> 
        <td class="border border-gray-300 dark:border-gray-700 p-6"> ${discipline.id_discipline}</td>
        <td class="border border-gray-300 dark:border-gray-700 p-6"> ${discipline.libelle}</td>
        <td class="border border-gray-300 dark:border-gray-700 p-6"> ${discipline.description}</td>
        </tr>
        `
    });
});
}


formDiscipline.addEventListener("submit",function(event){
    event.preventDefault();
    const discipline={
        libelle: document.getElementById("libelle").value,
        description: document.getElementById("description").value
    }
    fetch(API_URL,{
        method:"POST",
        headers:{
            "content-type":"application/json"
        },
        body: JSON.stringify(discipline)

    })
    .then(()=>{
        formDiscipline.reset();
       
        afficherDisciplines();
    })
    

})
afficherDisciplines();