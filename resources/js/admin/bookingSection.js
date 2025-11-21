window.addEventListener("DOMContentLoaded", function () {
  // customer inquiry list
  const searchByName = document.getElementById("search_booking_name");
  const filterByDate = document.getElementById("filter_booking_date");
  const filterByStatus = document.getElementById("filter_booking_status");
  const sortByDate = document.getElementById("sort_booking_date");
  const bookingListBody = document.getElementById("booking_list_body");

  fetchBookingData("", "", "", "");

  searchByName.addEventListener("keyup", function () {
    console.log(this.value);
    const searchNameValue = this.value.trim();
    const filterByDateValue = filterByDate.value;
    const filterByStatusValue = filterByStatus.value;
    const sortByDateValue = sortByDate.value;
    fetchBookingData(
      searchNameValue,
      filterByDateValue,
      filterByStatusValue,
      sortByDateValue
    );
  });

  filterByDate.addEventListener("change", function () {
    console.log(this.value);
    const searchNameValue = searchByName.value.trim();
    const filterByDateValue = this.value;
    const filterByStatusValue = filterByStatus.value;
    const sortByDateValue = sortByDate.value;
    fetchBookingData(
      searchNameValue,
      filterByDateValue,
      filterByStatusValue,
      sortByDateValue
    );
  });

  filterByStatus.addEventListener("change", function () {
    console.log(this.value);
    const searchNameValue = searchByName.value.trim();
    const filterByDateValue = filterByDate.value;
    const filterByStatusValue = this.value;
    const sortByDateValue = sortByDate.value;
    fetchBookingData(
      searchNameValue,
      filterByDateValue,
      filterByStatusValue,
      sortByDateValue
    );
  });

  sortByDate.addEventListener("change", function () {
    console.log(this.value);
    const searchNameValue = searchByName.value.trim();
    const filterByDateValue = filterByDate.value;
    const filterByStatusValue = filterByStatus.value;
    const sortByDateValue = this.value;
    fetchBookingData(
      searchNameValue,
      filterByDateValue,
      filterByStatusValue,
      sortByDateValue
    );
  });

  function fetchBookingData(
    searchNameValue,
    filterByDateValue,
    filterByStatusValue,
    sortByDateValue
  ) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "fetchBooking.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        bookingListBody.innerHTML = xhr.responseText;
      } else {
        bookingListBody.innerHTML =
          '<div class="inquiry-list-item customer-question-list"><p>Error Loading Data: ' +
          xhr.status +
          "</p> </div>";
      }
    };

    xhr.onerror = function () {
      console.error("Connection error has occured during AJAX request");
      bookingListBody.innerHTML =
        '<div class="inquiry-list-item customer-question-list"><p>Connection Failed!</p> </div>';
    };

    xhr.send(
      "searchNameValue=" +
        encodeURIComponent(searchNameValue) +
        "&filterByDateValue=" +
        encodeURIComponent(filterByDateValue) +
        "&filterByStatusValue=" +
        encodeURIComponent(filterByStatusValue) +
        "&sortByDateValue=" +
        encodeURIComponent(sortByDateValue)
    );
  }
});
