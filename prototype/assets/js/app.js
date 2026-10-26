// ============================================
// 1. Récupération des éléments du DOM
// ============================================
const form = document.getElementById('formDiscipline');
const btnAjouter = document.getElementById('btnAjouter');
const btnAnnuler = document.getElementById('btnAnnuler');
const formContainer = document.getElementById('formContainer');
const tableBody = document.getElementById('tableBody');

// On récupère le bouton "Enregistrer" à l'intérieur du formulaire
const btnSubmit = form.querySelector('button[type="submit"]');

const API = 'api/controllers/DisciplineController.php';

// ============================================
// 2. Créer le conteneur toasts s'il n'existe pas
// ============================================
if (!document.getElementById('toasts')) {
    const div = document.createElement('div');
    div.id = 'toasts';
    div.className = 'fixed bottom-4 right-4 flex flex-col gap-2 z-50';
    document.body.appendChild(div);
}

// ============================================
// 3. Gestion de l'état du bouton (Loading)
// ============================================
function setLoadingState(isLoading) {
    btnSubmit.disabled = isLoading;
    btnSubmit.textContent = isLoading ? 'Enregistrement…' : 'Enregistrer';
}

// ============================================
// 4. Fonction Toast (Notification)
// ============================================
function toast(message, ok = true) {
    const div = document.createElement('div');
    div.className = `text-white px-4 py-2 rounded shadow ${ok ? 'bg-green-500' : 'bg-red-500'}`;
    div.textContent = message;
    document.getElementById('toasts').appendChild(div);
    setTimeout(() => div.remove(), 3000);
}

// ============================================
// 5. Afficher les disciplines
// ============================================
async function charger() {
    try {
        const res = await fetch(API);
        const data = await res.json();

        tableBody.innerHTML = data.map(d => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-4 text-gray-500">${d.id}</td>
                <td class="p-4 font-semibold text-gray-800">${d.libelle}</td>
                <td class="p-4 text-gray-600">${d.description}</td>
            </tr>
        `).join('');
    } catch (error) {
        toast('Erreur lors du chargement', false);
    }
}

// ============================================
// 6. Ouvrir / Fermer le formulaire
// ============================================
btnAjouter.addEventListener('click', () => {
    formContainer.style.display = 'block';
});

btnAnnuler.addEventListener('click', () => {
    formContainer.style.display = 'none';
    form.reset();
});

// ============================================
// 7. Soumettre le formulaire (Ajouter)
// ============================================
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Bloquer l'interface
    setLoadingState(true);

    try {
        const res = await fetch(API, {
            method: 'POST',
            body: new FormData(form)
        });
        const data = await res.json();

        if (data.success) {
            toast('Discipline ajoutée ✅');
            form.reset();
            formContainer.style.display = 'none'; // Cacher le formulaire après ajout
            charger(); // Recharger le tableau
        } else {
            toast(data.message || 'Erreur', false);
        }
    } catch (error) {
        toast('Erreur réseau', false);
    } finally {
        // Débloquer l'interface
        setLoadingState(false);
    }
});

// ============================================
// 8. Démarrage
// ============================================
formContainer.style.display = 'none'; // Cacher le formulaire au chargement
charger();