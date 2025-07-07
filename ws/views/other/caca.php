<?php
require_once __DIR__ . '/ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des étudiants</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <p><a href="<?php echo BASE_URL; ?>/etablissement">établissement</a></p>
  <p><a href="<?php echo BASE_URL; ?>/client">client</a></p>
  <p><a href="<?php echo BASE_URL; ?>/investisseur">investisseur</a></p>

  <h1>Gestion des étudiants</h1>

  <div>
    <input type="hidden" id="id">
    <input type="text" id="nom" placeholder="Nom">
    <input type="text" id="prenom" placeholder="Prénom">
    <input type="email" id="email" placeholder="Email">
    <input type="number" id="age" placeholder="Âge">
    <button onclick="ajouterOuModifier()">Ajouter / Modifier</button>
  </div>

  <table id="table-etudiants">
    <thead>
      <tr>
        <th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Âge</th><th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>


  <script>
  const apiBase = "http://localhost/S4/ProjetS4/ws";   // remove () if you can

  /* -------------------------------------------------
     Generic AJAX helper (single xhr.send)
  ------------------------------------------------- */
  function ajax(method, url, data, callback, sendJson = false) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, apiBase + url, true);

    if (sendJson) {
      xhr.setRequestHeader("Content-Type", "application/json");
      data = JSON.stringify(data);
    } else {
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    }

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        callback(JSON.parse(xhr.responseText || "[]"));
      }
    };
    xhr.send(data);
  }

  /* -------------------------------------------------
     Load and display all types de prêt
  ------------------------------------------------- */
  function chargerTypePret() {
    ajax("GET", "/typePrets", null, (data) => {
      const tbody = document.querySelector("#table-TypePret tbody");
      tbody.innerHTML = "";

      data.forEach(tp => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${tp.id}</td>
          <td>${tp.nom}</td>
          <td>${tp.taux}</td>
          <td>${tp.duree}</td>
          <td>
            <button onclick='remplirFormulaire(${JSON.stringify(tp)})'>✏️</button>
            <button onclick='supprimerTypePret(${tp.id})'>🗑️</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    });
  }

  /* -------------------------------------------------
     Add or update a record
  ------------------------------------------------- */
  function ajouterOuModifier() {
    const id    = document.getElementById("id").value.trim();
    const nom   = document.getElementById("nom").value.trim();
    const taux  = document.getElementById("taux").value.trim();
    const duree = document.getElementById("duree").value.trim();

    if (!nom || !taux || !duree) return alert("Champs requis manquants.");

    if (id) {
      ajax("PUT", `/typePrets/${id}`, { nom, taux, duree }, () => {
        resetForm();
        chargerTypePret();
      }, true);          // sendJson = true
    } else {
      const qs =
        `nom=${encodeURIComponent(nom)}&taux=${taux}&duree=${duree}`;

      ajax("POST", "/typePrets", qs, () => {
        resetForm();
        chargerTypePret();
      });
    }
  }

  /* -------------------------------------------------
     Helpers
  ------------------------------------------------- */
  function remplirFormulaire(tp) {
    document.getElementById("id").value    = tp.id;
    document.getElementById("nom").value   = tp.nom;
    document.getElementById("taux").value  = tp.taux;
    document.getElementById("duree").value = tp.duree;
  }

  function supprimerTypePret(id) {
    if (confirm("Supprimer ce type de prêt ?")) {
      ajax("DELETE", `/typePrets/${id}`, null, () => chargerTypePret());
    }
  }

  function resetForm() {
    ["id","nom","taux","duree"].forEach(id => document.getElementById(id).value = "");
  }

  /* -------------------------------------------------
     Initial load
  ------------------------------------------------- */
  chargerTypePret();
</script>

</body>
</html>