const form = document.getElementById('form-discipline');
const btn = document.getElementById('btn-submit');
const tableBody = document.getElementById('table-body');
const API = 'api/controllers/DisciplineController.php';

// --- Toast simple ---
function toast(message, ok = true) {
    const div = document.createElement('div');
    div.className = `text-white px-4 py-2 rounded shadow ${ok ? 'bg-green-500' : 'bg-red-500'}`;
    div.textContent = message;
    document.getElementById('toasts').appendChild(div);
    setTimeout(() => div.remove(), 3000);
}

// --- Afficher les disciplines ---
async function charger() {
    const res = await fetch(API);
    const data = await res.json();

    tableBody.innerHTML = data.map(d => `
        <tr class="border-b">
            <td class="p-3">${d.id}</td>
            <td class="p-3 font-semibold">${d.libelle}</td>
            <td class="p-3 text-gray-600">${d.description}</td>
        </tr>
    `).join('');
}

// --- Ajouter une discipline ---
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    btn.disabled = true;
    btn.textContent = 'Enregistrement...';

    try {
        const res = await fetch(API, { method: 'POST', body: new FormData(form) });
        const data = await res.json();

        if (data.success) {
            toast('Discipline ajoutée ✅');
            form.reset();
            charger();
        } else {
            toast(data.message, false);
        }
    } catch {
        toast('Erreur réseau', false);
    } finally {
        btn.disabled = false;
        btn.textContent = 'Enregistrer';
    }
});

// --- Démarrage ---
charger();