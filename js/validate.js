document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("feedbackForm");

  form.addEventListener("submit", function(event) {
    let email = document.getElementById("email").value;
    let name = document.getElementById("name").value;

    if (name.trim() === "" || email.trim() === "") {
      alert("Please fill out all required fields!");
      event.preventDefault();
    }

    // basic email validation
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.match(emailPattern)) {
      alert("Please enter a valid email address!");
      event.preventDefault();
    }
  });
});
