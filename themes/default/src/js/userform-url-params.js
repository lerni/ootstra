/**
 * Preselect UserForm fields based on URL parameters
 *
 * Usage: Add URL parameters matching field names
 * Example: ?EditableTextField_ad731=Reparaturauftrag
 */

function preselectUserFormFields() {
	const urlParams = new URLSearchParams(window.location.search);

	if (urlParams.size === 0) {
		return;
	}

	const form = document.querySelector('.userform');
	if (!form) {
		return;
	}

	urlParams.forEach((value, fieldName) => {
		if (['flush', 'showtemplate', 'debug', 'referrer', 'isDev'].includes(fieldName)) {
			return;
		}

		const fields = form.querySelectorAll(`[name="${fieldName}"]`);

		if (fields.length === 0) {
			return;
		}

		const firstField = fields[0];
		const fieldType = firstField.type;

		switch (fieldType) {
			case 'radio':
			case 'checkbox':
				fields.forEach(field => {
					if (field.value === value) {
						field.checked = true;
						field.dispatchEvent(new Event('change', { bubbles: true }));
						if (window.jQuery) {
							window.jQuery(field).trigger('change');
						}
					}
				});
				break;

			case 'select-one':
			case 'select-multiple':
				firstField.value = value;
				firstField.dispatchEvent(new Event('change', { bubbles: true }));
				if (window.jQuery) {
					window.jQuery(firstField).trigger('change');
				}
				break;

			case 'text':
			case 'email':
			case 'tel':
			case 'number':
			case 'date':
			case 'textarea':
				firstField.value = decodeURIComponent(value);
				firstField.dispatchEvent(new Event('input', { bubbles: true }));
				firstField.dispatchEvent(new Event('change', { bubbles: true }));
				if (window.jQuery) {
					window.jQuery(firstField).trigger('input').trigger('change');
				}
				break;

			default:
				firstField.value = decodeURIComponent(value);
				firstField.dispatchEvent(new Event('change', { bubbles: true }));
				if (window.jQuery) {
					window.jQuery(firstField).trigger('change');
				}
		}
	});
}

// Run after userforms.js has initialized (it uses jQuery .ready())
// window.load fires after DOMContentLoaded, so jQuery plugins are ready
window.addEventListener('load', preselectUserFormFields);
