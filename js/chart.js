new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
      datasets: [
        {
          label: "Fichiers envoyés",
          backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#999999","#e6e600" ],
          data: [2478,1267,734,784,433,675,968]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Nombre de fichiers envoyés semaine'
      }
    }
});

new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ["png", "jpg", "pdf", "xlsx", "docx", "zip", "Autres"],
      datasets: [{
        label: "Extensions fichiers",
        backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#e6e600","#999999" ],
        data: [15,5,5,10,25,10,30]
      }]
    },
    options: {
      title: {
        display: true,
        text: "Pourcentage de téléchargements par type d'extension"
      }
    }
});

new Chart(document.getElementById("line-chart"), {
    type: 'line',
    data: {
      labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
      datasets: [{ 
          data: [2478,5267,734,784,433,675,968],
          label: "Fichiers téléchargés",
          borderColor: "#3e95cd",
          fill: false
        }]
    },
    options: {
      title: {
        display: true,
        text: 'Nombre de fichiers téléchargés semaine'
      }
    }
  });

  // SELECT COUNT(link_id) AS nbr FROM file_upload
  // SELECT COUNT(link_id) AS nbr FROM file_upload GROUP BY upload_date
  // SELECT name, DAY(upload_date) FROM file_upload WHERE WEEK(upload_date) = 50
  // SELECT DAYOFWEEK('2018-12-15') FROM file_upload
  // SELECT name, DAYOFWEEK(upload_date) AS day FROM file_upload WHERE WEEK(upload_date) = 50
  // SELECT name, DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) FROM file_upload WHERE WEEK(upload_date) = 50 GROUP BY DAYOFWEEK(upload_date)