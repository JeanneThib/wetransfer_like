// const connexion = document.querySelector("#connexion");
// const login = document.querySelector("#login");
// const pass = document.querySelector("#pass");

// function verify(element, event) {

//     element.addEventListener(event, (e) => {

//         if (event === "click") {
//             let data = new FormData();
//             data.append("login", login.value);
//             data.append("pass", pass.value);
        
//             fetch("/wetransfer_like/admin/verifForm", {method: "POST", body: data})
//             .then( (result) => { return result.json() } )
//             .then( (result) => {
//                 // console.log(result.error);
//                 if(!result.error){
//                     window.location.replace("/wetransfer_like/dashboard");
//                 } else {
//                     document.querySelector("#error").innerHTML = result.error;
//                 }
//             });
//         }
//     })
// }

// verify(connexion, "click");
// verify(login, "keydown");
// verify(pass, "keydown");


// option = document.querySelectorAll(".week-option");

// for (let i = 0; i < option.length; i++) {
//     option[i].addEventListener("click", () => {
//         console.log("Tu as cliqué sur la semaine " + i);
//     })
// }
// function displayChart(val) {
//     console.log("Tu as cliqué sur la semaine " + val);
// }
let sel = document.querySelector('#week');
var dayArr = [0,0,0,0,0,0,0];

document.addEventListener('DOMContentLoaded',function() {
    sel.onchange=changeWeek;
},false);

function changeWeek() {
    console.log(sel.value);


    let data = new FormData();
    data.append("week", sel.value);

    fetch("/wetransfer_like/dashboard/week", {method: "POST", body: data})
    .then( (result) => { return result.json() } )
    .then( (result) => {
        // console.log(result);
        // console.log(result[1]["day"]);
        dayArr[0] = result[0]["nbr"];
        console.log(dayArr[0]);
    });


}



new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
      datasets: [
        {
          label: "Fichiers envoyés",
          backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#999999","#e6e600" ],
          data: dayArr
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
  // SELECT DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr FROM file_upload WHERE WEEK(upload_date) = 50 OR WEEK(upload_date) = 51 GROUP BY DAYOFWEEK(upload_date)

  // SELECT upload_date, DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr FROM file_upload WHERE WEEK(upload_date) = 50 OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1) GROUP BY DAYOFWEEK(upload_date)
  // SELECT DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr FROM file_upload WHERE WEEK(upload_date) = 50 OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1) GROUP BY DAYOFWEEK(upload_date)