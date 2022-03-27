window.addEventListener('DOMContentLoaded', () => {
  const switchValue = checkbox => checkbox.value = checkbox.checked;
  document.querySelectorAll('input[type=checkbox]').forEach(checkbox =>
    checkbox.addEventListener('change', event =>
      switchValue(event.currentTarget)));
});
