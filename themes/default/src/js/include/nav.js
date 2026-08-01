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
  // 1st click on a parent opens its submenu, 2nd click navigates (desktop + mobile)
  const menu1 = document.querySelector(".menu1");
  if (menu1) {
    const collapseAll = (except) => {
      menu1.querySelectorAll("li.has-children.expanded").forEach((li) => {
        if (li !== except) collapse(li);
      });
    };

    const expand = (li) => {
      li.classList.add("expanded");
      li.querySelectorAll("[aria-controls]").forEach((el) =>
        el.setAttribute("aria-expanded", "true")
      );
    };

    const collapse = (li) => {
      li.classList.remove("expanded");
      li.querySelectorAll("[aria-controls]").forEach((el) =>
        el.setAttribute("aria-expanded", "false")
      );
    };

    menu1.addEventListener("click", (event) => {
      // toggle button: open/close without navigating
      const trigger = event.target.closest("button.trigger");
      if (trigger) {
        event.preventDefault();
        const li = trigger.closest("li");
        if (li.classList.contains("expanded")) {
          collapse(li);
        } else {
          collapseAll(li);
          expand(li);
        }
        return;
      }
      // parent link: open on first click, navigate on second
      const parentLink = event.target.closest("li.has-children > a");
      if (parentLink) {
        const li = parentLink.closest("li");
        if (!li.classList.contains("expanded")) {
          event.preventDefault();
          collapseAll(li);
          expand(li);
        }
      }
    });

    // Escape closes the open submenu and returns focus to its parent link
    menu1.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        const li = event.target.closest("li.has-children.expanded");
        if (li) {
          collapse(li);
          li.querySelector(":scope > a").focus();
        }
      }
    });

    // click outside the header closes any open submenu (desktop only)
    document.addEventListener("click", (event) => {
      if (
        !event.target.closest("#header") &&
        !document.querySelector("html").classList.contains("mobile-nav--active")
      ) {
        collapseAll();
      }
    });
  }

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
