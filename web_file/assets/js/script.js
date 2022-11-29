let navbar_right = document.getElementById("navbar_right");
let auth_form_login = document.getElementById("auth_form_login");
let auth_form_register = document.getElementById("auth_form_register");

//Membuat event listener berupa click pada element dengan id = "navbar_open"
//element "navbar_open" disini berupa icon menu pada navbar saat screen < 960px (tampilan tablet)
document.getElementById("navbar_open").addEventListener('click', () => {
    //Maksud dari right 0 disini adalah untuk menampilkan side nav
    navbar_right.style.right = "0";
})

//Membuat event listener berupa click pada element dengan id = "navbar_close"
//element "navbar_close" disini berupa icon menu pada navbar saat screen < 960px (tampilan tablet)
document.getElementById("navbar_close").addEventListener('click', () => {
    //Cek jika screen > 768px maka element side nav akan disembunyikan ke kanan dari screen (tampilan tablet)
    //Atau digeser ke kanan sehingga berada diluar screen
    //Digeser ke kanan sebesar 32vw atau 32% dari ukuran screen
    if(window.innerWidth > 768) navbar_right.style.right = "-32vw";
    //Digeser ke kanan sebesar 62vw atau 62% dari ukuran screen jika ukuran screen < 768px (tampilan mobile)
    else navbar_right.style.right = "-62vw";
})