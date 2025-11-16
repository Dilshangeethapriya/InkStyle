function deleteProduct(productID) {
  if (confirm("Are you sure, you want to remove this product?")) {
    window.location.href = "./deleteProduct.php?productID=" + productID;
  }
}
