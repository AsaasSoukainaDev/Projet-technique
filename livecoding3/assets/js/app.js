const form=document.getElementById('formDiscipline');
const formContainer=document.getElementById('formContainer');

const btnAjouter=document.getElementById('btnAjouter');
const btnAnnuler=document.getElementById('btnAnnuler');

const tableBody=document.getElementById('tableBody');
const API = "api/controllers/DisciplineController.php";

btnAjouter.addEventListener("click",()=>{
    formContainer.style.display="block";
})
function toast(message,ok=true){

    const div=document.createElement("div");
    div.id='toasts';
    div.className=`text-white px-4 py-2 ${ok ? 'bg-green-500':'bg-red-500'}`;
    div.textContent=message;
    document.getElementById('toasts').appendChild(div);
    
}


form.addEventListener("submit",async (e) => {
    e.preventDefault();

     try{

        const res= await fetch(API,{
            method:'POST',
            body:new FormData(form)

        })
        const data= await res.json();

        if (data.success) {

            toast("Discipline ajoutee");

            form.reset();

            charger();
            
            
        }
    }catch(error){
        toast("erreur",false);
    }
    
}) 
charger();