function showCard(n) {

    document.querySelectorAll(".card").forEach(c => c.classList.remove("active"))

    document.getElementById("card" + n).classList.add("active")

}

function setType(type) {

    document.getElementById("type").value = type

    if (type == "anonymous") {

        document.getElementById("nameField").style.display = "none"

    } else {

        document.getElementById("nameField").style.display = "block"

    }

    showCard(3)

}