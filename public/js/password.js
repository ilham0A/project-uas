document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#togglePassword");
  const passwordInput = document.querySelector("#password");

  togglePassword.addEventListener("click", function () {
    // Periksa tipe input saat ini
    const type = passwordInput.type === "password" ? "text" : "password";
    passwordInput.type = type;

    // Ubah ikon mata
    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
  });
});
