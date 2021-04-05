function openNav() {
    document.getElementById("sidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.getElementById("header").style.marginLeft = "250px";
    document.getElementById("form").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.getElementById("header").style.marginLeft= "0";
    document.getElementById("form").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}

function getCountries() {
    let regionId = document.getElementById("regionFormSelect").value;
    if (regionId !== "") {
        document.getElementById("form-regions").submit();
    } else {
        document.getElementById("countries-section").style.display = 'none';
    }
}
