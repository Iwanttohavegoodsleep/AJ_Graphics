function toggleServices() {
    var services = document.getElementById("services");
    if (services.style.display === "none" || services.style.display === "") {
        services.style.display = "block";
    } else {
        services.style.display = "none";
    }
}