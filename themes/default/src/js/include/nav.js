document.addEventListener("DOMContentLoaded", function () {
  init();
});

document.body.addEventListener("htmx:afterSettle", function (event) {
  init();
});

function init() {
  // burger
  const menuButton = document.querySelector("#menuButton");
  if (menuButton) {
    menuButton.addEventListener("click", (event) => {
      document.querySelector("html").classList.toggle("mobile-nav--active");
      let isExpanded = menuButton.getAttribute("aria-expanded") === "true";
      menuButton.setAttribute("aria-expanded", !isExpanded);
      document.getElementById("header").scrollIntoView();
    });
  }

  // toggle expanded-class
  // open and do not navigate on collapsed:not(.expanded) navi-items on mobile nav (touch)
  const menu1 = document.querySelector(".menu1");
  if (menu1) {
    menu1.addEventListener("click", (event) => {
      if (event.target.closest("li.has-children.expanded >a")) {
        window.location = event.target.getAttribute("href");
      } else if (
        document.querySelector("html").classList.contains("mobile-nav--active") &&
        event.target.closest("li.has-children >a")
      ) {
        event.preventDefault();
        event.target.parentElement.classList.toggle("expanded");
      }
    });

    menu1.addEventListener("mouseleave", (event) => {
      if (!document.querySelector("html").classList.contains("mobile-nav--active")) {
        const items = document.querySelectorAll(".menu1 li");
        items.forEach((i) => {
          i.classList.remove("expanded");
        });
      }
    });
  }

  // collapse/expand navi per .trigger
  const triggers = document.querySelectorAll("span.trigger");
  triggers.forEach((trigger) => {
    trigger.addEventListener("click", (event) => {
      event.target.closest("li").classList.toggle("expanded");
    });
  });

  // Arrow key navigation
  const topLevelMenuItems = Array.prototype.slice.call(
    document.querySelectorAll(".menu1 > li > a")
  );
  const allMenuItems = Array.prototype.slice.call(
    document.querySelectorAll(".menu1 > li > a, .menu2 > li > a")
  );

  allMenuItems.forEach(function (menuItem, index) {
    menuItem.addEventListener("keydown", function (event) {
      var prevIndex = (index - 1 + allMenuItems.length) % allMenuItems.length;
      var nextIndex = (index + 1) % allMenuItems.length;

      switch (event.key) {
        case "ArrowUp":
          allMenuItems[prevIndex].focus();
          event.preventDefault();
          break;
        case "ArrowDown":
          allMenuItems[nextIndex].focus();
          event.preventDefault();
          break;
      }
    });
  });

  topLevelMenuItems.forEach(function (menuItem, index) {
    menuItem.addEventListener("keydown", function (event) {
      var prevIndex =
        (index - 1 + topLevelMenuItems.length) % topLevelMenuItems.length;
      var nextIndex = (index + 1) % topLevelMenuItems.length;

      switch (event.key) {
        case "ArrowLeft":
          topLevelMenuItems[prevIndex].focus();
          event.preventDefault();
          break;
        case "ArrowRight":
          topLevelMenuItems[nextIndex].focus();
          event.preventDefault();
          break;
      }
    });
  });
}

// we need to prevent loading from cache if back-button is used, cos ios-safari would apply the fadeTo-effect to the destination not the original
window.onpageshow = (event) => {
  if (event.persisted) {
    window.location.reload();
  }
};
