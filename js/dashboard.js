let sel = document.querySelector('#week');
// var bar_chart = new Chart(document.getElementById("bar-chart"));

// fonction semaine
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

    // fetch initial
    
    fetch("/wetransfer_like/dashboard/week/" + sel.value, {method: "POST", body: firstData})
    .then( (result) => { return result.json() } )
    .then( (result) => {

        uploadArr = [0,0,0,0,0,0,0];
        extArr = [0,0,0,0,0,0,0];
        extUpArr = [0,0,0,0,0,0,0];
        downloadArr = [0,0,0,0,0,0,0];
        for (let i = 0; i < result["upload"].length; i++) {
            jour = parseInt(result["upload"][i]["day"]);
            if(jour === 1) {
                uploadArr[6] = result["upload"][i]["nbr"];   
            } else {
                uploadArr[(jour - 2)] = result["upload"][i]["nbr"];
            }
        }

        switchFetch("upload_extension", extArr, result);
        switchFetch("download_extension", extUpArr, result);

        for (let l = 0; l < result["download"].length; l++) {
            jour = parseInt(result["download"][l]["day"]);
            if(jour === 1) {
                downloadArr[6] = result["download"][l]["nbr"];   
            } else {
                downloadArr[(jour - 2)] = result["download"][l]["nbr"];
            }
        }

        chartBar();
        chartPie();
        chartPie2();
        chartLine();
        
    });

    
  });

document.addEventListener('DOMContentLoaded',function() {
    sel.onchange=changeWeek;
},false);

var uploadArr = [0,0,0,0,0,0,0];
var extArr = [0,0,0,0,0,0,0];
var extUpArr = [0,0,0,0,0,0,0];
var downloadArr = [0,0,0,0,0,0,0];


function changeWeek() {
    
    
    let data = new FormData();
    data.append("week", sel.value);
    
    fetch("/wetransfer_like/dashboard/week/" + sel.value, {method: "POST", body: data})
    .then( (result) => { return result.json() } )
    .then( (result) => {
        bar_chart.destroy();
        pie_chart.destroy();
        pie_chart2.destroy();
        line_chart.destroy();
        uploadArr = [0,0,0,0,0,0,0];
        extArr = [0,0,0,0,0,0,0];
        extUpArr = [0,0,0,0,0,0,0];
        downloadArr = [0,0,0,0,0,0,0];
        for (let i = 0; i < result["upload"].length; i++) {
            jour = parseInt(result["upload"][i]["day"]);
            if(jour === 1) {
                uploadArr[6] = result["upload"][i]["nbr"];   
            } else {
                uploadArr[(jour - 2)] = result["upload"][i]["nbr"];
            }
        }

        switchFetch("upload_extension", extArr, result);
        switchFetch("download_extension", extUpArr, result);

            for (let l = 0; l < result["download"].length; l++) {
                jour = parseInt(result["download"][l]["day"]);
                if(jour === 1) {
                    downloadArr[6] = result["download"][l]["nbr"];   
                } else {
                    downloadArr[(jour - 2)] = result["download"][l]["nbr"];
                }
            }

        chartBar();
        chartPie();
        chartPie2();
        chartLine();
        
    });

    
}

  function chartBar () {
    bar_chart = new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
          labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
          datasets: [
            {
              label: "Fichiers envoyés",
              backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#999999","#e6e600" ],
              data: uploadArr
            }
          ]
        },
        options: {
          legend: { display: false },
          title: {
            display: true,
            text: 'Nombre de fichiers envoyés semaine ' + sel.value
          },
          scales: {
            yAxes: [{
                display: true,
                ticks: {
                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                    // OR //
                    beginAtZero: true   // minimum value will be 0.
                }
            }]
        }
        }
    });
  }

  function chartPie () {
    pie_chart = new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
          labels: ["png", "jpg", "pdf", "xlsx", "docx", "zip", "Autres"],
          datasets: [{
            label: "Extensions fichiers",
            backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#e6e600","#999999" ],
            data: extArr
          }]
        },
        options: {
          title: {
            display: true,
            text: "Pourcentage d'envoi par type d'extension semaine " + sel.value
          }
        }
    });
  }

  function chartPie2 () {
    pie_chart2 = new Chart(document.getElementById("pie-chart2"), {
        type: 'pie',
        data: {
          labels: ["png", "jpg", "pdf", "xlsx", "docx", "zip", "Autres"],
          datasets: [{
            label: "Extensions fichiers",
            backgroundColor: ["#3e95cd", "#8e5ea2","#248f24","#ff9933","#ff4d4d","#e6e600","#999999" ],
            data: extUpArr
          }]
        },
        options: {
          title: {
            display: true,
            text: "Pourcentage de téléchargements par type d'extension semaine " + sel.value
          }
        }
    });
  }

  function chartLine () {
    line_chart = new Chart(document.getElementById("line-chart"), {
        type: 'line',
        data: {
        labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
        datasets: [{ 
            data: downloadArr,
            label: "Fichiers téléchargés",
            borderColor: "#3e95cd",
            fill: false
            }]
        },
        options: {
        title: {
            display: true,
            text: 'Nombre de fichiers téléchargés semaine ' + sel.value
        },
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    suggestedMin: 0,
                    // suggestedMax: 2,
                    // minimum will be 0, unless there is a lower value.
                    beginAtZero: true   // minimum value will be 0.
                }
            }]
        }
        }
    });
   }

   function switchFetch (idx, arr, result) {
    for (let j = 0; j < result[idx].length; j++) {
        extension = result[idx][j]["extension"];

        switch (extension) {
            case "png":
                arr[0] = parseInt(result[idx][j]["percent"]);
                break;
            case "jpg":
                arr[1] = parseInt(result[idx][j]["percent"]);                    
                break;
            case "pdf":
                arr[2] = parseInt(result[idx][j]["percent"]);                
                break;
            case "xlsx":
                arr[3] = parseInt(result[idx][j]["percent"]);                    
                break;
            case "docx":
                arr[4] = parseInt(result[idx][j]["percent"]);                    
                break;
            case "zip":
                arr[5] = parseInt(result[idx][j]["percent"]);                                       
                break;
        
            default:
                arr[6] += parseInt(result[idx][j]["percent"]);
                break;
        }
    }
   }