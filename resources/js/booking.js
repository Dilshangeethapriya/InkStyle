const serviceSelect = document.getElementById("serviceSelect");
let selectedServices = [];
let totalDuration = 0;
const dateInput = document.getElementById("booking_date");
const timeInput = document.getElementById("booking_time");
const bookingForm = document.getElementById("booking_form");

servicesListData.forEach((service) => {
  let tattooSize = service.tattooSize ? "(" + service.tattooSize + ")" : "";
  serviceSelect.innerHTML +=
    '<option value="' +
    service.serviceID +
    '" >' +
    service.serviceName +
    " " +
    tattooSize +
    "</option>";
});

window.addEventListener("DOMContentLoaded", function () {
  const addServiceBtn = document.getElementById("add_service_btn");

  addServiceBtn.addEventListener("click", addService);
});

const today = new Date();
today.setDate(today.getDate() + 1);
dateInput.min = today.toISOString().split("T")[0];

dateInput.addEventListener("input", function () {
  const pickedDate = new Date(this.value);
  if (pickedDate.getDay() === 0) {
    alert("We are closed on Sundays. Please pick another date.");
    this.value = "";
  }
});

bookingForm.addEventListener("submit", function (event) {
  if (
    selectedServices.length === 0 ||
    dateInput.value === "" ||
    timeInput.value === ""
  ) {
    event.preventDefault();
    alert("Complete all fileds before continue");
  }
});

function addService() {
  const selectedID = serviceSelect.value;

  if (!selectedID) {
    return;
  }

  const service = servicesListData.find((service) => {
    return service.serviceID == selectedID;
  });

  if (
    selectedServices.some((service) => {
      return service.serviceID == selectedID;
    })
  ) {
    alert("Service already added!");
    return;
  }

  selectedServices.push(service);
  updateServiceList();
  updateTotalDuration();
  updateHiddenInputs();
}

function updateServiceList() {
  const serviceList = document.getElementById("serviceList");
  serviceList.innerHTML = "";

  selectedServices.forEach((service) => {
    let li = document.createElement("li");
    li.innerHTML = `${service.serviceName} (${service.estimatedServiceTime} min)   <button style="width:25px; background-color:#e45400ff;color:white; padding:2px; border-radius: 8px; border:none;" onclick="removeService(${service.serviceID})"><i class="fa-solid fa-x"></i></button>`;
    serviceList.appendChild(li);
  });
}

function removeService(id) {
  selectedServices = selectedServices.filter((service) => {
    return service.serviceID != id;
  });
  updateServiceList();
  updateTotalDuration();
  updateHiddenInputs();
}

function updateTotalDuration() {
  totalDuration = 0;
  selectedServices.forEach((service) => {
    totalDuration += parseInt(service.estimatedServiceTime);
  });
  document.getElementById("totalDuration").innerText = totalDuration;
  document.getElementById("total_duration_input").value = totalDuration;

  if (totalDuration > 0) {
    enableInputDate();
    enableInputTime();
  } else {
    disableInputDate();
    disableInputTime();
    resetDateTimeInputs();
  }
}

function updateHiddenInputs() {
  const container = document.getElementById("hiddenInputs");
  container.innerHTML = "";

  selectedServices.forEach((service) => {
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "services[]";
    input.value = service.serviceID;
    container.appendChild(input);
  });
}

function disableInputDate() {
  if (dateInput.disabled === false) {
    dateInput.disabled = true;
  }
}

function enableInputDate() {
  if (dateInput.disabled === true) {
    dateInput.disabled = false;
  }
}

function disableInputTime() {
  if (timeInput.disabled === false) {
    timeInput.disabled = true;
  }
}

function enableInputTime() {
  if (timeInput.disabled === true) {
    timeInput.disabled = false;
  }
}

function resetDateTimeInputs() {
  dateInput.value = "";
  timeInput.value = "";
}
