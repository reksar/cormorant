window.addEventListener('DOMContentLoaded', () => {
  const checkbox = document.querySelector('#notify_admin_on_confirmation');
  const template = document.querySelector('#notify_email_template');
  const templateTr = template.closest('tr');
  const switchTemplateDisplay = () =>
    templateTr.style.display = checkbox.checked ? '' : 'none';

  switchTemplateDisplay();
  checkbox.addEventListener('change', switchTemplateDisplay);
});
