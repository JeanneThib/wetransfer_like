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
        // bar_chart.destroy();
        // pie_chart.destroy();
        // pie_chart2.destroy();
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
            // console.log(jour);
            // console.log(uploadArr);
        }

        for (let j = 0; j < result["upload_extension"].length; j++) {
            extension = result["upload_extension"][j]["extension"];

            switch (extension) {
                case "png":
                    extArr[0] = parseInt(result["upload_extension"][j]["percent"]);
                    break;
                case "jpg":
                    extArr[1] = parseInt(result["upload_extension"][j]["percent"]);                    
                    break;
                case "pdf":
                    extArr[2] = parseInt(result["upload_extension"][j]["percent"]);                
                    break;
                case "xlsx":
                    extArr[3] = parseInt(result["upload_extension"][j]["percent"]);                    
                    break;
                case "docx":
                    extArr[4] = parseInt(result["upload_extension"][j]["percent"]);                    
                    break;
                case "zip":
                    extArr[5] = parseInt(result["upload_extension"][j]["percent"]);                                       
                    break;
            
                default:
                    extArr[6] += parseInt(result["upload_extension"][j]["percent"]);
                    break;
            }
        }

        for (let k = 0; k < result["download_extension"].length; k++) {
            extension_download = result["download_extension"][k]["extension"];

            switch (extension_download) {
                case "png":
                    extUpArr[0] = parseInt(result["download_extension"][k]["percent"]);
                    break;
                case "jpg":
                    extUpArr[1] = parseInt(result["download_extension"][k]["percent"]);                    
                    break;
                case "pdf":
                    extUpArr[2] = parseInt(result["download_extension"][k]["percent"]);                
                    break;
                case "xlsx":
                    extUpArr[3] = parseInt(result["download_extension"][k]["percent"]);                    
                    break;
                case "docx":
                    extUpArr[4] = parseInt(result["download_extension"][k]["percent"]);                    
                    break;
                case "zip":
                    extUpArr[5] = parseInt(result["download_extension"][k]["percent"]);                                       
                    break;
            
                default:
                    extUpArr[6] += parseInt(result["download_extension"][k]["percent"]);
                    break;
            }
        }

        for (let l = 0; l < result["download"].length; l++) {
            jour = parseInt(result["download"][l]["day"]);
            if(jour === 1) {
                downloadArr[6] = result["download"][l]["nbr"];   
            } else {
                downloadArr[(jour - 2)] = result["download"][l]["nbr"];
            }
        }
        console.log(downloadArr);


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
        console.log(result["upload"]);
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
            // console.log(jour);
            // console.log(uploadArr);
        }

        for (let j = 0; j < result["upload_extension"].length; j++) {
            extension = result["upload_extension"][j]["extension"];

            switch (extension) {
                case "png":
                    extArr[0] = parseInt(result["upload_extension"][j]["percent"]);
                    break;
                case "jpg":
                    extArr[1] = parseInt(result["upload_extension"][j]["percent"]);                    
                    break;
                case "pdf":
                    extArr[2] = parseInt(result["upload_extension"][j]["percent"]);                
                    break;
                case "xlsx":
                    extArr[3] = parseInt(result["upload_extension"][j]["percent"]);                    
                    break;
                case "docx":
                    extArr[4] = parseInt(result["upload_extension"][j]["percent"]);                    
                    break;
                case "zip":
                    extArr[5] = parseInt(result["upload_extension"][j]["percent"]);                                       
                    break;
            
                default:
                    extArr[6] += parseInt(result["upload_extension"][j]["percent"]);
                    break;
            }

            for (let k = 0; k < result["download_extension"].length; k++) {
                extension_download = result["download_extension"][k]["extension"];
    
                switch (extension_download) {
                    case "png":
                        extUpArr[0] = parseInt(result["download_extension"][k]["percent"]);
                        break;
                    case "jpg":
                        extUpArr[1] = parseInt(result["download_extension"][k]["percent"]);                    
                        break;
                    case "pdf":
                        extUpArr[2] = parseInt(result["download_extension"][k]["percent"]);                
                        break;
                    case "xlsx":
                        extUpArr[3] = parseInt(result["download_extension"][k]["percent"]);                    
                        break;
                    case "docx":
                        extUpArr[4] = parseInt(result["download_extension"][k]["percent"]);                    
                        break;
                    case "zip":
                        extUpArr[5] = parseInt(result["download_extension"][k]["percent"]);                                       
                        break;
                
                    default:
                        extUpArr[6] += parseInt(result["download_extension"][k]["percent"]);
                        break;
                }
            }

            for (let l = 0; l < result["download"].length; l++) {
                jour = parseInt(result["download"][l]["day"]);
                if(jour === 1) {
                    downloadArr[6] = result["download"][l]["nbr"];   
                } else {
                    downloadArr[(jour - 2)] = result["download"][l]["nbr"];
                }
            }
            // if(extension === "") {
            //     extArr[6] = result["extension"][j]["nbr"];   
            // } else {
            //     extArr[(jour - 2)] = result["extension"][j]["nbr"];
            // }
            // console.log(jour);
            // console.log(uploadArr);
        }
        console.log(extArr);


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
            text: 'Nombre de fichiers téléchargés semaine'
        },
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    suggestedMin: 0,
                    // suggestedMax: 2,
                    // minimum will be 0, unless there is a lower value.
                    // OR //
                    beginAtZero: true   // minimum value will be 0.
                }
            }]
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

  // Select extension, ROUND((Count(extension)* 100 / (Select Count(*) From file_upload))) as Score From file_upload Group By extension
  // Select extension, ROUND((Count(extension)* 100 / (Select Count(*) From file_upload))) as percent
  // From file_upload WHERE (WEEK(upload_date) = 50 AND DAYOFWEEK(upload_date) != 1 ) OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1)
  // Group By extension

  // Select extension, ROUND((Count(extension)* 100 / (Select Count(*) From file_upload WHERE (WEEK(upload_date) = 50 AND DAYOFWEEK(upload_date) != 1 ) OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1)))) as percent
  // From file_upload WHERE (WEEK(upload_date) = 50 AND DAYOFWEEK(upload_date) != 1 ) OR (WEEK(upload_date) = 51 AND DAYOFWEEK(upload_date) = 1)
  // Group By extension


//   SELECT extension, ROUND((Count(extension)* 100 / 
//         (SELECT Count(*) FROM file_download 
//         WHERE (WEEK(download_date) = 51 - 1 
//         AND DAYOFWEEK(download_date) != 1 ) 
//         OR (WEEK(download_date) = 51 
//         AND DAYOFWEEK(download_date) = 1)))) 
//         AS percent
//         FROM file_download 
//         WHERE (WEEK(download_date) = 51 - 1 
//         AND DAYOFWEEK(download_date) != 1 ) 
//         OR (WEEK(download_date) = 51 
//         AND DAYOFWEEK(download_date) = 1)
//         GROUP BY extension