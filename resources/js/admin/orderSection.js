window.addEventListener("DOMContentLoaded", function () {
  // customer inquiry list
  const searchOrderByName = document.getElementById("search_order_name");
  const filterOrderByDate = document.getElementById("filter_order_date");
  const filterOrderByStatus = document.getElementById("filter_order_status");
  const sortOrderByDate = document.getElementById("sort_order_date");
  const ordersListBody = document.getElementById("orders-list-body");

  fetchBookingData(
    searchOrderByName.value.trim(),
    filterOrderByDate.value,
    filterOrderByStatus.value,
    sortOrderByDate.value
  );

  searchOrderByName.addEventListener("keyup", function () {
    console.log(this.value);
    const searchNameValue = this.value.trim();
    const filterOrderByDateValue = filterOrderByDate.value;
    const filterOrderByStatusValue = filterOrderByStatus.value;
    const sortOrderByDateValue = sortOrderByDate.value;
    fetchBookingData(
      searchNameValue,
      filterOrderByDateValue,
      filterOrderByStatusValue,
      sortOrderByDateValue
    );
  });

  filterOrderByDate.addEventListener("change", function () {
    console.log(this.value);
    const searchNameValue = searchOrderByName.value.trim();
    const filterOrderByDateValue = this.value;
    const filterOrderByStatusValue = filterOrderByStatus.value;
    const sortOrderByDateValue = sortOrderByDate.value;
    fetchBookingData(
      searchNameValue,
      filterOrderByDateValue,
      filterOrderByStatusValue,
      sortOrderByDateValue
    );
  });

  filterOrderByStatus.addEventListener("change", function () {
    console.log(this.value);
    const searchNameValue = searchOrderByName.value.trim();
    const filterOrderByDateValue = filterOrderByDate.value;
    const filterOrderByStatusValue = this.value;
    const sortOrderByDateValue = sortOrderByDate.value;
    fetchBookingData(
      searchNameValue,
      filterOrderByDateValue,
      filterOrderByStatusValue,
      sortOrderByDateValue
    );
  });

  sortOrderByDate.addEventListener("change", function () {
    console.log(this.value);
    const searchNameValue = searchOrderByName.value.trim();
    const filterOrderByDateValue = filterOrderByDate.value;
    const filterOrderByStatusValue = filterOrderByStatus.value;
    const sortOrderByDateValue = this.value;
    fetchBookingData(
      searchNameValue,
      filterOrderByDateValue,
      filterOrderByStatusValue,
      sortOrderByDateValue
    );
  });

  function fetchBookingData(
    searchNameValue,
    filterOrderByDateValue,
    filterOrderByStatusValue,
    sortOrderByDateValue
  ) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "fetchOrder.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        ordersListBody.innerHTML = xhr.responseText;
      } else {
        ordersListBody.innerHTML =
          '<div class="inquiry-list-item customer-question-list"><p>Error Loading Data: ' +
          xhr.status +
          "</p> </div>";
      }
    };

    xhr.onerror = function () {
      console.error("Connection error has occured during AJAX request");
      ordersListBody.innerHTML =
        '<div class="inquiry-list-item customer-question-list"><p>Connection Failed!</p> </div>';
    };

    xhr.send(
      "searchNameValue=" +
        encodeURIComponent(searchNameValue) +
        "&filterOrderByDateValue=" +
        encodeURIComponent(filterOrderByDateValue) +
        "&filterOrderByStatusValue=" +
        encodeURIComponent(filterOrderByStatusValue) +
        "&sortOrderByDateValue=" +
        encodeURIComponent(sortOrderByDateValue)
    );
  }
});
