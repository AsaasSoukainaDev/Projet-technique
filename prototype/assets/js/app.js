const form = document.getElementById('formDiscipline');
const btnAjouter = document.getElementById('btnAjouter');
const btnAnnuler = document.getElementById('btnAnnuler');
const formContainer = document.getElementById('formContainer');
const tableBody = document.getElementById('tableBody');
const btnSubmit = document.querySelector('button[type="submit"]');

const API = "api/controllers/DisciplineController.php";


function setLoadingState(isLoading) {
    btnSubmit.disabled = isLoading;
    btnSubmit.textContent = isLoading ? "Enregistrement..." : "Enregistrer";
}

function toast(message, ok = true) {
    const div = document.createElement("div");
    div.className = `text-white px-4 py-2 rounded shadow ${ok ? 'bg-green-500' : 'bg-red-500'}`;
    div.textContent = message;
    document.getElementById('toasts').appendChild(div);
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

btnAjouter.addEventListener("click", () => {
    formContainer.style.display = "block";
});

btnAnnuler.addEventListener("click", () => {
    formContainer.style.display = "none";
    form.reset();
});

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    setLoadingState(true);

    try {
        const res = await fetch(API, {
            method: 'POST',
            body: new FormData(form)
        });
        const data = await res.json();

        if (data.success) {
            toast("Discipline ajoutée ✅");
            form.reset();
            formContainer.style.display = "none";
            charger(); 
        } else {
            // CORRECTION 1 : Le toast d'erreur est maintenant dans le else
            toast(data.message || 'Erreur', false);
        }
    } catch (error) {
        toast('Erreur réseau', false);
    } finally {
        setLoadingState(false);
    }
});

formContainer.style.display = 'none';
charger();