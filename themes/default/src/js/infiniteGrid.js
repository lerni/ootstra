import { MasonryInfiniteGrid } from "@egjs/infinitegrid";
// import { MasonryInfiniteGrid, JustifiedInfiniteGrid, FrameInfiniteGrid, PackingInfiniteGrid } from "@egjs/infinitegrid";

// Store grid instances to allow cleanup and avoid memory leaks
let gridInstances = [];

/**
 * Initialize masonry grid for all matching elements
 */
function initMasonryGrids() {
  // Destroy any existing instances first to prevent duplicates
  destroyGridInstances();

  // Find all masonry holders in the document
  const masonryHolders = document.querySelectorAll('.masonry-holder');

  // Create new grid instances for each holder
  masonryHolders.forEach(holder => {
    if (!holder.dataset.gridInitialized) {
      // Use responsive gap: 56 for viewports > 1600px, 28 for smaller viewports
      const gap = window.innerWidth > 1600 ? 56 : 28;
      const grid = new MasonryInfiniteGrid(holder, { gap: gap });
      grid.renderItems();

      // Mark this element as initialized
      holder.dataset.gridInitialized = 'true';

      // Store the instance for potential cleanup
      gridInstances.push({
        element: holder,
        instance: grid
      });
    }
  });
}

/**
 * Clean up existing grid instances to prevent memory leaks
 */
function destroyGridInstances() {
  gridInstances.forEach(item => {
    if (item.instance && typeof item.instance.destroy === 'function') {
      item.instance.destroy();
      if (item.element) {
        delete item.element.dataset.gridInitialized;
      }
    }
  });
  gridInstances = [];
}

// Handle viewport resize to update gap
window.addEventListener('resize', function() {
  // Debounce resize events to avoid excessive re-initialization
  clearTimeout(window.resizeTimeout);
  window.resizeTimeout = setTimeout(() => {
    initMasonryGrids();
  }, 250);
});

// // Watch for HTMX content swaps
// document.body.addEventListener('htmx:afterSwap', function(event) {
//   // Initialize any new masonry grids after content is swapped
//   initMasonryGrids();
// });

// // Also initialize after content is fully settled (in case images need to load)
// document.body.addEventListener('htmx:afterSettle', function(event) {
//   // Re-render all grids after content has fully settled
//   gridInstances.forEach(item => {
//     if (item.instance && typeof item.instance.renderItems === 'function') {
//       item.instance.renderItems();
//     }
//   });
// });

// Use MutationObserver to detect DOM changes
const observer = new MutationObserver(mutations => {
  // Look for added nodes that contain masonry-holder
  const shouldReinitialize = mutations.some(mutation => {
    return Array.from(mutation.addedNodes).some(node => {
      return node.nodeType === 1 && (
        node.classList?.contains('masonry-holder') ||
        node.querySelector?.('.masonry-holder')
      );
    });
  });

  if (shouldReinitialize) {
    initMasonryGrids();
  }
});

// Start observing document body for changes
observer.observe(document.body, {
  childList: true,
  subtree: true
});

// Initialize immediately in case the DOM is already loaded
initMasonryGrids();
