let sel = document.querySelector('#week');
var bar_chart = new Chart(document.getElementById("bar-chart"));


$( document ).ready(function() {


    Date.prototype.getYearDay = function() { //1 - 366
        var year  = this.getFullYear();
        var month = this.getMonth();
        var day   = this.getDate();
        
        var offset = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        
        //l'année bissextile n'est utile qu'à partir de mars
        var bissextile = (month < 2) ? 0 : (year % 400 == 0 || (year % 4 == 0 && year % 100 != 0));
        
        return parseInt(day + offset[month] + bissextile);
    }
    
    Date.prototype.getMonday = function() {
        var offset = (this.getDay() + 6) % 7;
        return new Date(this.getFullYear(), this.getMonth(), this.getDate()-offset);
    }
    
    Date.prototype.getWeek = function() { //1 - 53
        var year = this.getFullYear();
        var week;
        
        //dernier lundi de l'année
        var lastMonday = new Date(year, 11, 31).getMonday();
        
        //la date est dans la dernière semaine de l'année
        //mais cette semaine fait partie de l'année suivante
        if(this >= lastMonday && lastMonday.getDate() > 28) {
            week = 1;
        }
        else {
            //premier lundi de l'année
            var firstMonday = new Date(year, 0, 1).getMonday();
            
            //correction si nécessaire (le lundi se situe l'année précédente)
            if(firstMonday.getFullYear() < year) firstMonday = new Date(year, 0, 8).getMonday();
            
            //nombre de jours écoulés depuis le premier lundi
            var days = this.getYearDay() - firstMonday.getYearDay();
            
            //window.alert(days);
            
            //si le nombre de jours est négatif on va chercher
            //la dernière semaine de l'année précédente (52 ou 53)
            if(days < 0) {
                week = new Date(year, this.getMonth(), this.getDate()+days).getWeek();
            }
            else {
                //numéro de la semaine
                week = 1 + parseInt(days / 7);
                
                //on ajoute une semaine si la première semaine
                //de l'année ne fait pas partie de l'année précédente
                week += (new Date(year-1, 11, 31).getMonday().getDate() > 28);
            }
        }
        
        return parseInt(week);

        
    }

    let currDate = new Date().getWeek();

    sel.value = currDate;


    let firstData = new FormData();
    firstData.append("week", sel.value);
    
    fetch("/wetransfer_like/dashboard/week/" + sel.value, {method: "POST", body: firstData})
    .then( (result) => { return result.json() } )
    .then( (result) => {
        bar_chart.destroy();
        dayArr = [0,0,0,0,0,0,0];
        for (let i = 0; i < result.length; i++) {
            jour = parseInt(result[i]["day"]);
            if(jour === 1) {
                dayArr[6] = result[i]["nbr"];   
            } else {
                dayArr[(jour - 2)] = result[i]["nbr"];
            }
            // console.log(jour);
            // console.log(dayArr);
        }
        console.log(dayArr);


        chartBar();
        
    });

    
  });



document.addEventListener('DOMContentLoaded',function() {
    sel.onchange=changeWeek;
},false);

new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
      datasets: [
        {
          label: "Fichiers envoyés",
          backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#999999","#e6e600" ],
          data: [0,0,0,0,0,0,0]
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
var dayArr = [0,0,0,0,0,0,0];

function changeWeek() {
    
    
    let data = new FormData();
    data.append("week", sel.value);
    
    fetch("/wetransfer_like/dashboard/week/" + sel.value, {method: "POST", body: data})
    .then( (result) => { return result.json() } )
    .then( (result) => {
        bar_chart.destroy();
        dayArr = [0,0,0,0,0,0,0];
        for (let i = 0; i < result.length; i++) {
            jour = parseInt(result[i]["day"]);
            if(jour === 1) {
                dayArr[6] = result[i]["nbr"];   
            } else {
                dayArr[(jour - 2)] = result[i]["nbr"];
            }
            // console.log(jour);
            // console.log(dayArr);
        }
        console.log(dayArr);


        chartBar();
        
    });

    

    
    
}


new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ["png", "jpg", "pdf", "xlsx", "docx", "zip", "Autres"],
      datasets: [{
        label: "Extensions fichiers",
        backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#e6e600","#999999" ],
        data: [5,15,20,30,5,10,15]
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




//   function addData(data) {
//     dataset.data.push(data);
//     chart.update();
// }

  

  function chartBar () {
    bar_chart = new Chart(document.getElementById("bar-chart"), {
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
            text: 'Nombre de fichiers envoyés semaine ' + sel.value
          }
        }
    });
  }


  // SELECT COUNT(link_id) AS nbr FROM file_upload
  // SELECT COUNT(link_id) AS nbr FROM file_upload GROUP BY upload_date
  // SELECT name, DAY(upload_date) FROM file_upload WHERE WEEK(upload_date) = 50
  // SELECT DAYOFWEEK('2018-12-15') FROM file_upload
  // SELECT name, DAYOFWEEK(upload_date) AS day FROM file_upload WHERE WEEK(upload_date) = 50
  // SELECT name, DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) FROM file_upload WHERE WEEK(upload_date) = 50 GROUP BY DAYOFWEEK(upload_date)
  // SELECT DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr FROM file_upload WHERE WEEK(upload_date) = 50 OR WEEK(upload_date) = 51 GROUP BY DAYOFWEEK(upload_date)

  // SELECT upload_date, DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr FROM file_upload WHERE WEEK(upload_date) = 50 OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1) GROUP BY DAYOFWEEK(upload_date)
  // SELECT DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr FROM file_upload WHERE WEEK(upload_date) = 50 OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1) GROUP BY DAYOFWEEK(upload_date)