window.onload = function () {
  registerExpandableGridEventListeners();
};

document.body.addEventListener("htmx:afterSwap", function (event) {
  registerExpandableGridEventListeners();
});

function registerExpandableGridEventListeners() {
  var cells = Array.from(
    document.querySelectorAll(".expandable-grid .expandable__cell")
  );

  if (cells.length) {
    cells.forEach((cell) => {
      cell.addEventListener("click", (event) => {
        clickedCell = event.target.closest(".expandable__cell");
        if (clickedCell.classList.contains("is--collapsed")) {
          cells.forEach((eachCell) => {
            eachCell.classList.remove("is--expanded");
            eachCell.classList.add("is--collapsed");
          });
          clickedCell.classList.remove("is--collapsed");
          clickedCell.classList.add("is--expanded");
        }

        hash = clickedCell.getAttribute("id");
        history.pushState(
          null,
          null,
          window.location.protocol +
            "//" +
            window.location.host +
            window.location.pathname +
            "#" +
            hash
        );
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      var hash = window.location.hash.substring(1);

      if (hash.length && isNaN(parseFloat(hash))) {
        document.getElementById(hash).classList.remove("is--collapsed");
        document.getElementById(hash).classList.add("is--expanded");
      }
    });
  }

  var closeXs = Array.from(document.querySelectorAll(".expand__close"));
  if (closeXs.length) {
    closeXs.forEach((closeX) => {
      closeX.addEventListener("click", (event) => {
        event.stopPropagation();
        clickedXParent = event.target.closest(".expandable__cell");
        clickedXParent.classList.remove("is--expanded");
        clickedXParent.classList.add("is--collapsed");
      });
    });
  }
}
