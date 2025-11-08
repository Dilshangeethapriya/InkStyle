function deleteService(serviceID) {
  if (confirm("Are you sure, you want to delete this service?")) {
    window.location.href = "./deleteService.php?serviceID=" + serviceID;
  }
}
