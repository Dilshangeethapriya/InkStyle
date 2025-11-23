const numFormatter = new Intl.NumberFormat("en-US");

const cartCards = document.querySelectorAll(".item-card");

cartCards.forEach((card) => {
  const minusBtn = card.querySelector(".minus");
  const plusBtn = card.querySelector(".plus");
  const qtyInput = card.querySelector(".quantity-input");
  const priceP = card.querySelector(".price");
  const subTotalP = card.querySelector(".total");

  const itemID = card.getAttribute("data-item-id");

  function updateTotals() {
    const price = parseFloat(priceP.dataset.price);
    const qty = parseInt(qtyInput.value);
    const itemTotal = price * qty;

    subTotalP.textContent = "LKR " + numFormatter.format(itemTotal) + ".00";
    updateGrandTotal();

    fetch("updateCartQty.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `itemID=${itemID}&qty=${qty}`,
    });
  }

  plusBtn.addEventListener("click", () => {
    let qty = parseInt(qtyInput.value);
    if (qty < parseInt(qtyInput.max)) {
      qty++;
      qtyInput.value = qty;
      updateTotals();
    }
  });

  minusBtn.addEventListener("click", () => {
    let qty = parseInt(qtyInput.value);
    if (qty > parseInt(qtyInput.min)) {
      qty--;
      qtyInput.value = qty;
      updateTotals();
    }
  });

  qtyInput.addEventListener("change", () => {
    let qty = parseInt(qtyInput.value);
    if (qty < parseInt(qtyInput.min)) {
      qtyInput.value = 1;
    }
    if (qty > parseInt(qtyInput.max)) {
      qtyInput.value = 10;
    }
    updateTotals();
  });
});

function updateGrandTotal() {
  let grandTotal = 0;
  document.querySelectorAll(".item-card").forEach((card) => {
    let price = parseFloat(card.querySelector(".price").dataset.price);
    let qty = parseInt(card.querySelector(".quantity-input").value);
    let itemTotal = price * qty;
    console.log(itemTotal);
    grandTotal += itemTotal;
  });

  document.querySelector(".grand-total").innerHTML =
    "<strong>Grand total :</strong> LKR " +
    numFormatter.format(grandTotal) +
    ".00";
}

function removeCartItem(itemID) {
  if (confirm("Are you sure, you want to remove this product from the cart?")) {
    window.location.href = "./removeCartItem.php?itemID=" + itemID;
  }
}
