document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".contact-form");

  form.addEventListener("submit", function (event) {
    let isValid = true;
    let errorMessages = [];

    const nameField = document.getElementById("name");
    const emailField = document.getElementById("email");
    const messageField = document.getElementById("message");

    // Validation du champ nom
    if (nameField.value.trim() === "") {
      isValid = false;
      errorMessages.push("Le champ nom est requis.");
    }

    // Validation du champ email
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!emailField.value.match(emailPattern)) {
      isValid = false;
      errorMessages.push("Veuillez entrer une adresse e-mail valide.");
    }

    // Validation du champ message
    if (messageField.value.trim() === "") {
      isValid = false;
      errorMessages.push("Le message ne peut pas être vide.");
    }

    // Si le formulaire n'est pas valide, afficher les erreurs
    if (!isValid) {
      event.preventDefault(); // Empêche l'envoi du formulaire si non valide
      alert(errorMessages.join("\n"));
    }
  });

  // Gestion du mode sombre avec LocalStorage
  const darkModeToggle = document.getElementById("dark-mode-toggle");
  const body = document.body;

  // Vérifier si l'utilisateur a une préférence de mode sombre stockée
  if (localStorage.getItem("darkMode") === "enabled") {
    body.classList.add("dark-mode");
  }

  darkModeToggle.addEventListener("click", function () {
    body.classList.toggle("dark-mode");

    // Sauvegarder la préférence dans le localStorage
    if (body.classList.contains("dark-mode")) {
      localStorage.setItem("darkMode", "enabled");
    } else {
      localStorage.removeItem("darkMode");
    }
  });
});