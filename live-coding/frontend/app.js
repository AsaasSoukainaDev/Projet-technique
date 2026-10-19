const API_URL ="../backend/api/GestionDiscipline.php";

const btnAjouter=document.getElementById("btnAjouter");
const btnAnnuler =document.getElementById("btnAnnuler");

const formContainer=document.getElementById("formContainer");
const formDiscipline =document.getElementById("formDiscipline");

const tableBody=document.getElementById("tableBody");
btnAjouter.addEventListener("click",function(){
    formContainer.style.display="block";
});



formDiscipline.addEventListener("submit",function(event){
    event.preventDefault();
    const discipline={
        libelle:document.getElementById("libelle").value,
        description:document.getElementById("description").value
    };

    fetch(API_URL,{
        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },
        body:JSON.stringify(discipline)
    })
    .then(()=>{
       formDiscipline.reset();
       
    });
});

