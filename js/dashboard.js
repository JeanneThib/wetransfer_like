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

document.addEventListener('DOMContentLoaded',function() {
    sel.onchange=changeWeek;
},false);

function changeWeek() {
    console.log(sel.value);


    let data = new FormData();
    data.append("week", sel.value);

    fetch("/wetransfer_like/dashboard/week", {method: "POST", body: data})
    .then( (result) => { return result.text() } )
    .then( (result) => {
        console.log(result);
    });


}
