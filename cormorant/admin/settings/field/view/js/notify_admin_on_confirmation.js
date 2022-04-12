window.addEventListener('DOMContentLoaded', () => {
  const checkbox = document.querySelector('#notify_admin_on_confirmation');
  const switchDisplay = () => checkbox.checked ? '' : 'none';

  const tr = css => document.querySelector(css).closest('tr');

  const subjectTr = tr('#notify_email_subject');
  const switchSubjectDisplay = () =>
    subjectTr.style.display = switchDisplay();

  const templateTr = tr('#notify_email_template');
  const switchTemplateDisplay = () =>
    templateTr.style.display = switchDisplay();

  // Initial display setting.
  switchSubjectDisplay();
  switchTemplateDisplay();

  checkbox.addEventListener('change', switchSubjectDisplay);
  checkbox.addEventListener('change', switchTemplateDisplay);
});
