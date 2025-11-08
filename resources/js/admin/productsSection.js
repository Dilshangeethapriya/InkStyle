function deleteProduct(productID) {
  if (confirm("Are you sure, you want to delete this product?")) {
    window.location.href = "./deleteProduct.php?productID=" + productID;
  }
}
