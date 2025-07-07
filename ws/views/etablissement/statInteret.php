<?php
require_once __DIR__ . '/../../config/config.php'; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Intérêts mensuels – Établissement Financier</title>
  <style>
    body { font-family:sans-serif; padding:20px; }
    label { margin-right:6px; }
    input, button { margin:3px; padding:5px; }
    table { border-collapse:collapse; width:100%; margin-top:20px; }
    th, td { border:1px solid #ccc; padding:8px; text-align:left; }
    th { background:#f2f2f2; }
    tfoot td { font-weight:bold; }
    #chart { max-height:350px; margin-top:30px; }
  </style>
</head>
<body>

<h1>Intérêts gagnés par mois</h1>

<div>
  <label>Début&nbsp;:</label>
  <input type="number" id="moisDebut" placeholder="Mois" min="1" max="12">
  <input type="number" id="anneeDebut" placeholder="Année">
  <label>Fin&nbsp;:</label>
  <input type="number" id="moisFin" placeholder="Mois" min="1" max="12">
  <input type="number" id="anneeFin" placeholder="Année">
  <button onclick="rechercher()">Appliquer</button>
</div>

<table id="tblInterets">
  <thead>
    <tr><th>Mois/Année</th><th>Intérêt </th></tr>
  </thead>
  <tbody></tbody>
  <tfoot>
    <tr><td>Total</td><td id="totalCell">0</td></tr>
  </tfoot>
</table>

<canvas id="chart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
const apiBase = "http://localhost<?= BASE_URL ?>";

function ajax(method, url, data, cb, json = false) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, apiBase + url, true);
  xhr.setRequestHeader(
       "Content-Type",
       json ? "application/json" : "application/x-www-form-urlencoded");
  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 300) {
      cb(JSON.parse(xhr.responseText || "[]"));
    } else {
      alert("Erreur " + xhr.status + " – voir console");
      console.error(xhr.responseText);
    }
  };
  xhr.send(json ? JSON.stringify(data) : data);
}

let chart;  
function renderChart(labels, data) {
  const ctx = document.getElementById("chart");
  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: "bar",               
    data: { labels, datasets: [{
      label: "Intérêt (€)",
      data
    }]},
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });
}

function remplirTableau(payload) {
  const rows  = payload.mois || [];
  const total = payload.total || 0;
  const tbody = document.querySelector("#tblInterets tbody");
  const totalCell = document.getElementById("totalCell");

  tbody.innerHTML = "";
  if (rows.length === 0) {
    tbody.innerHTML = `<tr><td colspan="2" style="text-align:center">
                         Aucun résultat
                       </td></tr>`;
    totalCell.textContent = "0";
    renderChart([], []);       // vide le graphe
    return;
  }

  const labels = [];
  const data   = [];

  rows.forEach(r => {
    const interet = Number(r.interet);
    labels.push(`${String(r.mois).padStart(2,"0")}/${r.annee}`);
    data.push(interet);

    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${labels.at(-1)}</td>
      <td>${interet.toFixed(2)}</td>`;
    tbody.appendChild(tr);
  });

  totalCell.textContent = total.toFixed(2);
  renderChart(labels, data);
}

function rechercher() {
  const md = +document.getElementById("moisDebut").value;
  const ad = +document.getElementById("anneeDebut").value;
  const mf = +document.getElementById("moisFin").value;
  const af = +document.getElementById("anneeFin").value;

  if (!md || !ad || !mf || !af) {
    alert("Veuillez renseigner tous les champs.");
    return;
  }

  ajax("POST", "/stat/interets",
       { moisDebut: md, anneeDebut: ad, moisFin: mf, anneeFin: af },
       remplirTableau, true);
}
</script>
</body>
</html>
