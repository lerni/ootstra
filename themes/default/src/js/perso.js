document.addEventListener('DOMContentLoaded', () => {
	function filterPersos(segment) {
		const filterElements = document.querySelectorAll(
			'.cat-tag a, .cat-tag button',
		);
		const persoItems = document.querySelectorAll('.perso');

		// Remove current class from all filter elements
		filterElements.forEach((el) => {
			el.classList.remove('current');
		});

		// Ignore stale/unrelated hashes that don't match a known department segment
		const knownSegment =
			segment &&
			document.querySelector(`.cat-tag a[data-segment="${segment}"]`);

		if (!knownSegment) {
			// Show all
			persoItems.forEach((item) => {
				item.classList.remove('hidden');
				item.classList.add('visible');
			});
			// Add current to "all" button
			document
				.querySelector('.cat-tag button.all, .cat-tag a.all')
				?.classList.add('current');
		} else {
			// Filter by department
			persoItems.forEach((item) => {
				const departments = item.dataset.departments || '';
				if (departments.includes(segment)) {
					item.classList.remove('hidden');
					item.classList.add('visible');
				} else {
					item.classList.remove('visible');
					item.classList.add('hidden');
				}
			});
			knownSegment.classList.add('current');
		}
	}

	// Handle click on filter elements
	document.querySelectorAll('.cat-tag a, .cat-tag button').forEach((el) => {
		el.addEventListener('click', (e) => {
			e.preventDefault();

			if (el.tagName === 'BUTTON') {
				// Button clears the hash (show all)
				history.pushState(
					null,
					'',
					window.location.pathname + window.location.search,
				);
				filterPersos('');
			} else {
				// Link sets hash for department filter
				const hash = el.getAttribute('href').split('#')[1];
				window.location.hash = hash || '';
				filterPersos(hash);
			}
		});
	});

	// Filter on page load based on URL hash
	const initialHash = window.location.hash.replace('#', '');
	filterPersos(initialHash);

	// Handle browser back/forward
	window.addEventListener('hashchange', () => {
		const hash = window.location.hash.replace('#', '');
		filterPersos(hash);
	});
});
