window.addEventListener("DOMContentLoaded", function () {
  const searchCustomerInput = document.getElementById("search_customer");
  const userListBody = document.getElementById("user-list-body");

  fetchCustomerData("");

  searchCustomerInput.addEventListener("keyup", function () {
    const searchValue = this.value.trim();
    fetchCustomerData(searchValue);
  });

  function fetchCustomerData(searchValue) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "fetchCustomer.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        userListBody.innerHTML = xhr.responseText;
      } else {
        console.error("AJX error: " + xhr.status);
        userListBody.innerHTML =
          '<div class="user-list-item customer-list"> <p>Error Loading Data: ' +
          xhr.status +
          "</p> </div>";
      }
    };

    xhr.onerror = function () {
      console.error("Connection error has occured during AJAX request");
      userListBody.innerHTML =
        '<div class="user-list-item customer-list"> <p>Connection failed!</p> </div>';
    };

    xhr.send("searchValue=" + encodeURIComponent(searchValue));
  }

  // staff data fetcher

  const searchStaffInput = document.getElementById("search_staff");
  const filterStaffInput = document.getElementById("filter_staff");
  const staffListBody = document.getElementById("user-list-body-staff");

  fetchStaffData("", "");

  searchStaffInput.addEventListener("keyup", function () {
    const searchStaffValue = this.value.trim();
    const filterStaffValue = filterStaffInput.value;
    fetchStaffData(searchStaffValue, filterStaffValue);
  });

  filterStaffInput.addEventListener("change", function () {
    const searchStaffValue = searchStaffInput.value.trim();
    const filterStaffValue = this.value;
    fetchStaffData(searchStaffValue, filterStaffValue);
  });

  function fetchStaffData(searchStaffValue, filterStaffValue) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "fetchStaff.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        staffListBody.innerHTML = xhr.responseText;
      } else {
        console.error("AJX error: " + xhr.status);
        staffListBody.innerHTML =
          '<div class="user-list-item staff-list"> <p>Error Loading Data: ' +
          xhr.status +
          "</p> </div>";
      }
    };

    xhr.onerror = function () {
      console.error("Connection error has occured during AJAX request");
      staffListBody.innerHTML =
        '<div class="user-list-item staff-list"> <p>Connection failed!</p> </div>';
    };

    xhr.send(
      "searchStaffValue=" +
        encodeURIComponent(searchStaffValue) +
        "&filterStaffValue=" +
        encodeURIComponent(filterStaffValue)
    );
  }
});
