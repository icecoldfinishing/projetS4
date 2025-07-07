<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des types de prêt</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>

  <h1>Gestion des types de prêt</h1>

  <div>
  <input type="hidden" id="id">
  <input type="text" id="nom" placeholder="Nom">
  <input type="number" id="taux" placeholder="Taux" step="0.01">
  <input type="hidden" id="duree" value="1">
  <button onclick="ajouterOuModifier()">Ajouter / Modifier</button>
</div>

  <table id="table-TypePret">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Taux</th>
        <th>Durée</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <script>
    const apiBase = "http://localhost/S4(htdocs)/projetS4/ws";

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
        if (xhr.readyState === 4) {
          if (xhr.status >= 200 && xhr.status < 300) {
            callback(JSON.parse(xhr.responseText || "{}"));
          } else {
            console.error("Erreur AJAX", xhr.status, xhr.responseText);
            alert("Erreur " + xhr.status + " — voir console.");
          }
        }
      };

      xhr.send(data);
    }

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

    function ajouterOuModifier() {
      const id = document.getElementById("id").value;
      const nom = document.getElementById("nom").value;
      const taux = document.getElementById("taux").value;
      const duree = document.getElementById("duree").value;

      const urlData = `nom=${encodeURIComponent(nom)}&taux=${taux}&duree=${duree}`;
      const body = { nom, taux, duree };

      if (id) {
        ajax("PUT", `/typePrets/${id}`, body, () => {
          resetForm();
          chargerTypePret();
        }, true);
      } else {
        ajax("POST", "/typePrets", urlData, () => {
          resetForm();
          chargerTypePret();
        });
      }
    }

    function remplirFormulaire(tp) {
      document.getElementById("id").value = tp.id;
      document.getElementById("nom").value = tp.nom;
      document.getElementById("taux").value = tp.taux;
      document.getElementById("duree").value = tp.duree;
    }

    function supprimerTypePret(id) {
      if (confirm("Supprimer ce type de prêt ?")) {
        ajax("DELETE", `/typePrets/${id}`, null, () => {
          chargerTypePret();
        });
      }
    }

    function resetForm() {
      document.getElementById("id").value = "";
      document.getElementById("nom").value = "";
      document.getElementById("taux").value = "";
      document.getElementById("duree").value = "";
    }

    chargerTypePret();
  </script>

</body>
</html>
