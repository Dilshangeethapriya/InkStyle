const cartIcon = document.getElementById("cart-icon");
const footer = document.getElementById("footer");

window.addEventListener("scroll", () => {
  let viewPortBottom = window.scrollY + window.innerHeight;
  let footerTopY = footer.offsetTop;

  console.log(window.scrollY + window.innerHeight);
  console.log("footer = " + footerTopY);

  if (viewPortBottom > footerTopY) {
    cartIcon.classList.add("stopped");
  } else {
    cartIcon.classList.remove("stopped");
  }
});
