// FAQ delete button action
function deleteFAQ(faqID) {
  if (confirm("Are you sure, you want to delete this FAQ?")) {
    window.location.href = "./deleteFAQ.php?faqID=" + faqID;
  }
}

window.addEventListener("DOMContentLoaded", function () {
  // customer inquiry list
  const searchInquiry = document.getElementById("search_inquiry");
  const filterInquiryStatus = document.getElementById("filter_inquiry_status");
  const sortInquirydate = document.getElementById("sort_inquiry_date");
  const inquiryListBody = document.getElementById("inquiry-list-body");

  fetchInquiryData("", "", "");

  searchInquiry.addEventListener("keyup", function () {
    const searchInquiryValue = this.value.trim();
    const filterInquiryValue = filterInquiryStatus.value;
    const sortInquiryValue = sortInquirydate.value;
    fetchInquiryData(searchInquiryValue, filterInquiryValue, sortInquiryValue);
  });

  filterInquiryStatus.addEventListener("change", function () {
    const searchInquiryValue = searchInquiry.value.trim();
    const filterInquiryValue = this.value;
    const sortInquiryValue = sortInquirydate.value;
    fetchInquiryData(searchInquiryValue, filterInquiryValue, sortInquiryValue);
  });

  sortInquirydate.addEventListener("change", function () {
    const searchInquiryValue = searchInquiry.value.trim();
    const filterInquiryValue = filterInquiryStatus.value;
    const sortInquiryValue = this.value;
    fetchInquiryData(searchInquiryValue, filterInquiryValue, sortInquiryValue);
  });

  function fetchInquiryData(
    searchInquiryValue,
    filterInquiryValue,
    sortInquiryValue
  ) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "fetchInquiry.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        inquiryListBody.innerHTML = xhr.responseText;
      } else {
        inquiryListBody.innerHTML =
          '<div class="inquiry-list-item customer-question-list"><p>Error Loading Data: ' +
          xhr.status +
          "</p> </div>";
      }
    };

    xhr.onerror = function () {
      console.error("Connection error has occured during AJAX request");
      inquiryListBody.innerHTML =
        '<div class="inquiry-list-item customer-question-list"><p>Connection Failed!</p> </div>';
    };

    xhr.send(
      "searchInquiryValue=" +
        encodeURIComponent(searchInquiryValue) +
        "&filterInquiryStatusValue=" +
        encodeURIComponent(filterInquiryValue) +
        "&sortInquiryValue=" +
        encodeURIComponent(sortInquiryValue)
    );
  }
});
