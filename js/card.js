document.addEventListener("DOMContentLoaded", function () {
  // 1. Card Number (Spaces every 4 digits)
  const ccInput = document.getElementById("cardNumber");
  if (ccInput) {
    ccInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length > 16) value = value.slice(0, 16);
      const parts = value.match(/.{1,4}/g);
      e.target.value = parts ? parts.join(" ") : value;
    });
  }

  // 2. CVV (Numbers only, max 3)
  const cvvInput = document.getElementById("cardCvv");
  if (cvvInput) {
    cvvInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length > 3) value = value.slice(0, 3);
      e.target.value = value;
    });
  }

  // 3. Expiration Date (Split Inputs: MM and YYYY)
  const expMonth = document.getElementById("expMonth");
  const expYear = document.getElementById("expYear");

  if (expMonth && expYear) {
    // Month Logic
    expMonth.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      e.target.value = value;

      // Auto-jump to Year after 2 digits
      if (value.length === 2) {
        if (parseInt(value) === 0) e.target.value = "01";
        if (parseInt(value) > 12) e.target.value = "12";
        expYear.focus();
      }
      e.target.classList.remove("border-danger");
    });

    // Year Logic (Typing)
    expYear.addEventListener("input", function (e) {
      e.target.value = e.target.value.replace(/\D/g, "");
      e.target.classList.remove("border-danger");
    });

    // Backspace Logic
    expYear.addEventListener("keydown", function (e) {
      if (e.key === "Backspace" && e.target.value === "") {
        expMonth.focus();
      }
    });

    // --- NEW: REALISTIC YEAR CHECK (On Blur) ---
    expYear.addEventListener("blur", function (e) {
      const inputYear = parseInt(e.target.value);
      const currentYear = new Date().getFullYear();
      const maxYear = currentYear + 20; // Allow cards expiring up to 20 years from now

      // If Year is empty, ignore (HTML 'required' handles that)
      if (!inputYear) return;

      // Logic: Year must be between NOW and NOW+20
      if (inputYear < currentYear || inputYear > maxYear) {
        alert(
          "Please enter a valid expiration year (e.g., " +
            currentYear +
            "-" +
            maxYear +
            ")"
        );
        e.target.value = ""; // Clear it
        e.target.classList.add("border-danger"); // Make it red
      } else {
        e.target.classList.remove("border-danger");
      }
    });
  }
});
