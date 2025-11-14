function deleteFAQ(faqID) {
  if (confirm("Are you sure, you want to delete this FAQ?")) {
    window.location.href = "./deleteFAQ.php?faqID=" + faqID;
  }
}
