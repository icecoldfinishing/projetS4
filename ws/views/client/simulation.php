<?php require_once __DIR__.'/../../../ws/config/config.php'; ?>
<!DOCTYPE html><html lang="fr"><head>
  <meta charset="utf-8">
  <title>Simulation de prêt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="<?= BASE_URL ?>/public/assets_template/css/theme.css" rel="stylesheet">
</head><body>
<main class="main" id="top">
  <!-- ----------- Formulaire de simulation ----------- -->
  <section class="pt-8">
    <div class="container-xxl">
      <h1>Simulation de prêt</h1>

      <div class="simulation-form">
        <div>
          <label for="valeur">Montant</label>
          <input type="number" id="valeur" placeholder="Montant " required>
        </div>
        <div>
          <label for="duree">Durée (mois)</label>
          <input type="number" id="duree" placeholder="Durée" required>
        </div>
        <div>
          <label for="id_typePret">Type de prêt</label>
          <select id="id_typePret" required>
            <option value="">Sélectionnez...</option>
          </select>
        </div>
        <button onclick="simulerPret()">Simuler</button>
      </div>

      <!-- Résultats -->
      <div id="resultat-simulation" style="display:none;margin-top:20px;padding:20px;border:1px solid #ddd;border-radius:5px;">
        <h3>Résultats</h3>
        <div id="details-simulation"></div>
      </div>
    </div>
  </section>
</main>

<script>
const apiBase = "http://localhost<?= BASE_URL ?>";

/* ------------- AJAX helper (JSON) ------------- */
function ajax(method, url, data, cb) {
  fetch(apiBase + url, {
    method,
    headers: { "Content-Type": "application/json" },
    body: method === "GET" ? null : JSON.stringify(data)
  })
  .then(r => r.json()).then(cb)
  .catch(e => { alert("Erreur réseau"); console.error(e); });
}

/* ------------- Charger types de prêt ----------- */
function chargerTypesPret() {
  ajax("GET", "/typePrets", null, data => {
    const sel = document.getElementById("id_typePret");
    sel.innerHTML = '<option value="">Sélectionnez...</option>';
    data.forEach(tp => {
      const opt = document.createElement("option");
      opt.value = tp.id;
      opt.textContent = `${tp.nom} (${tp.taux} % annuel)`;
      opt.dataset.taux = tp.taux;          // ← indispensable
      sel.appendChild(opt);
    });
  });
}

/* ------------- Simulation côté client ---------- */
function simulerPret() {
  const val = +document.getElementById("valeur").value;
  const n   = +document.getElementById("duree").value;
  const sel = document.getElementById("id_typePret");
  const tauxAnnuel = parseFloat(sel.options[sel.selectedIndex].dataset.taux);

  if (!val || !n || isNaN(tauxAnnuel)) { alert("Champs manquants"); return; }
  if (val <= 0 || n <= 0) { alert("Valeurs positives requises"); return; }

  const r  = tauxAnnuel / 100 / 12;
  const M  = +(val * r / (1 - Math.pow(1 + r, -n))).toFixed(2);
  const ct = +(M * n).toFixed(2);
  const cc = +(ct - val).toFixed(2);

  afficherResultat({
    success: true,
    data: {
      montant_emprunte: val,
      taux_interet: tauxAnnuel,
      duree: n,
      mensualite: M,
      cout_total: ct,
      cout_credit: cc,
      tableau_amortissement: []   // à remplir si besoin
    }
  });
}

/* ------------- Affichage résultat -------------- */
function afficherResultat(res) {
  const divRes = document.getElementById("resultat-simulation");
  const divDet = document.getElementById("details-simulation");
  if (res.success) {
    const d = res.data;
    divDet.innerHTML = `
      <p><strong>Montant emprunté :</strong> ${d.montant_emprunte.toLocaleString()} </p>
      <p><strong>Taux annuel :</strong> ${d.taux_interet}%</p>
      <p><strong>Durée :</strong> ${d.duree} mois</p>
      <p><strong>Mensualité :</strong> ${d.mensualite.toLocaleString()} </p>
      <p><strong>Coût total :</strong> ${d.cout_total.toLocaleString()} </p>
      <p><strong>Coût du crédit :</strong> ${d.cout_credit.toLocaleString()} </p>`;
  } else {
    divDet.innerHTML = `<div class="alert alert-danger">Erreur : ${res.message}</div>`;
  }
  divRes.style.display = "block";
  divRes.scrollIntoView({behavior:"smooth"});
}

/* ------------- Init ---------------------------- */
document.addEventListener("DOMContentLoaded", chargerTypesPret);
</script>
</body></html>
