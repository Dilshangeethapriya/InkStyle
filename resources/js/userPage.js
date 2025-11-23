function showTabs(contentId) {
  const tabs = document.querySelectorAll(".tabs-container .tab");
  const contents = document.querySelectorAll(".tabs-container .content");

  tabs.forEach((tab) => tab.classList.remove("active"));
  contents.forEach((content) => content.classList.remove("active"));

  const targetTab = document.querySelector(`.tab[onclick*="${contentId}"]`);
  const targetContetnt = document.getElementById(contentId);

  if (targetTab && targetContetnt) {
    targetTab.classList.add("active");
    targetContetnt.classList.add("active");
  }
}

window.addEventListener("load", () => {
  const hash = window.location.hash.substring(1);

  if (hash) {
    showTabs(hash);
  }
});

function cancelBooking(bookingID) {
  if (
    confirm(
      "WARNING: This booking cancellation is permanent and irreversible. Are you sure you want to cancel this booking?"
    )
  ) {
    window.location.href = "./cancelBooking.php?bookingID=" + bookingID;
  }
}

function cancelOrder(orderID) {
  if (
    confirm(
      "WARNING: This order cancellation is permanent and irreversible. Are you sure you want to cancel this order?"
    )
  ) {
    window.location.href = "./cancelOrder.php?orderID=" + orderID;
  }
}
