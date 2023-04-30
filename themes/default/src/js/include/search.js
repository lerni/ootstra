document.getElementById('Form_SearchForm').addEventListener('click', function (event) {
  event.stopPropagation();
  if (event.target.closest('.search-wrapper').classList.contains('search-collapsed')) {
    event.preventDefault();
    event.target.closest('.search-wrapper').classList.remove('search-collapsed');
    if(document.getElementById('Form_SearchForm_Search').value == 'Suchen') {
      document.getElementById('Form_SearchForm_Search').value = '';
    }
    document.getElementById('Form_SearchForm_Search').focus();
  }

});
document.getElementById('Form_SearchForm_Search').addEventListener('blur', function (event) {
  if (this.value == 'Suchen' || this.value.length < 1) {
    this.closest('.search-wrapper').classList.add('search-collapsed');
  }
});
