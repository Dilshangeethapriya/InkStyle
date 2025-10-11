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
