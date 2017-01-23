document.getElementById("open_search").addEventListener("click", function(event) {
    (function(event) {
        var searchBox = document.querySelector(".search-box");
        var displayValue = searchBox.style.display;
        if (displayValue.localeCompare("inline-block")) {
            searchBox.style.display = "inline-block";
        }
        else {
            searchBox.style.display = "none";
        }
    }).call(document.getElementById("open_search"), event);
});
document.getElementById("add-incidencia").addEventListener("click", function(event) {
    (function(event) {
        var wrapperHidden = document.querySelector(".wrapper-hidden");
        var addIncidenciaModal = document.querySelector(".add-modal");
        var wrapper = document.querySelector(".main");


        wrapper.style.zIndex = "0";
        wrapperHidden.style.zIndex = "1";
        addIncidenciaModal.style.visibility = "visible";
        addIncidenciaModal.style.display = "inline-block";
    }).call(document.getElementById("add-incidencia"), event);
});
document.getElementById("close-add-incidencia").addEventListener("click", function(event) {
    (function(event) {
        var wrapperHidden = document.querySelector(".wrapper-hidden");
        var addIncidenciaModal = document.querySelector(".add-modal");
        var wrapper = document.querySelector(".main");


        wrapper.style.zIndex = "1";
        wrapperHidden.style.zIndex = "0";
        addIncidenciaModal.style.visibility = "hidden";
        addIncidenciaModal.style.display = "none";
    }).call(document.getElementById("close-add-incidencia"), event);
});
document.getElementById("manage-users").addEventListener("click", function(event) {
    (function(event) {
        var wrapperHidden = document.querySelector(".wrapper-hidden");
        var manageUsersModal = document.querySelector(".manage-users-modal");
        var wrapper = document.querySelector(".main");


        wrapper.style.zIndex = "0";
        wrapperHidden.style.zIndex = "1";
        manageUsersModal.style.visibility = "visible";
        manageUsersModal.style.display = "inline-block";
    }).call(document.getElementById("add-incidencia"), event);
});
document.getElementById("close-manage-users").addEventListener("click", function(event) {
    (function(event) {
        var wrapperHidden = document.querySelector(".wrapper-hidden");
        var manageUsersModal = document.querySelector(".manage-users-modal");
        var wrapper = document.querySelector(".main");


        wrapper.style.zIndex = "1";
        wrapperHidden.style.zIndex = "0";
        manageUsersModal.style.visibility = "hidden";
        manageUsersModal.style.display = "none";
    }).call(document.getElementById("close-manage-users"), event);
});
