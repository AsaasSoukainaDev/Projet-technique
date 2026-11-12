const form = document.getElementById('formDiscipline');
const formContainer = document.getElementById('formContainer');
const btnAjouter = document.getElementById('btnAjouter');
const btnAnnuler = document.getElementById('btnAnnuler');
const tableBody = document.getElementById('tableBody');


const API = "http://localhost:8000/api/api.php"; 

btnAjouter.addEventListener("click", () => formContainer.style.display = "block");
btnAnnuler.addEventListener("click", () => {
    formContainer.style.display = "none";
    form.reset();
});

function toast(message, ok = true) {
    const container = document.getElementById('toasts');
    const div = document.createElement("div");
    div.className = `text-white px-4 py-2 rounded shadow m-2 ${ok ? 'bg-green-500' : 'bg-red-500'}`;
    div.textContent = message;
    container.appendChild(div);
    setTimeout(() => div.remove(), 3000);
}

async function charger() {
    try {
        const res = await fetch(API);
        const data = await res.json();
        tableBody.innerHTML = data.map(d => `
            <tr>  
                <td class="p-4">${d.id}</td>
                <td class="p-4">${d.libelle}</td>
                <td class="p-4">${d.description}</td>
            </tr>
        `).join('');
    } catch (error) {
        toast('Erreur lors du chargement', false);
    }
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const libelle = document.getElementById('libelle').value;
    const description = document.getElementById('description').value;

    try {
        const res = await fetch(API, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ libelle, description })
        });
        
        const data = await res.json();

        if (data.success) {
            toast("Discipline ajoutée ✅");
            form.reset();
            formContainer.style.display = "none";
            charger();
        } else {
           
            toast(data.message, false);
        }
    } catch (error) {
        toast("Erreur réseau", false);
    }
}); 

charger();