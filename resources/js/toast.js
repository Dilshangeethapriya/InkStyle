function showToast(message) {
  const toastContainer = document.getElementById("toast-container");
  const toast = document.createElement("div");
  toast.classList.add("toast");
  toast.textContent = message;

  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("show");
  }, 50);

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => {
      toast.remove();
    }, 200);
  }, 3000);
}
