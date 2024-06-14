function appendAlert(message, type, dismissible = true, timeout = 5000, extraElement = null) {
  const alertPlaceholder = document.getElementById('liveAlertPlaceholder');
  const wrapper = document.createElement('div');
  wrapper.className = `alert alert-${type} alert-dismissible fade show`;
  wrapper.role = 'alert';
  wrapper.innerHTML = `${message}`;

  if (extraElement) {
      wrapper.appendChild(extraElement);
  }

  alertPlaceholder.appendChild(wrapper);

  if (timeout > 0) {
      setTimeout(() => {
          wrapper.classList.remove('show');
          wrapper.addEventListener('transitionend', () => wrapper.remove());
      }, timeout);
  }
}
