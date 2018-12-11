const connexion = document.querySelector("#connexion");
const login = document.querySelector("#login");
const pass = document.querySelector("#pass");


connexion.addEventListener("click", () => {
    console.log(login.value);
    console.log(pass.value);

    let data = new FormData();
    data.append("login", login.value);
    data.append("pass", pass.value);

    fetch("controller/ctrl_admin.php", {method: "POST", body: data})
    .then( (result) => result.text() )
    .then( (result) => {
        console.log(result);
    })
})
