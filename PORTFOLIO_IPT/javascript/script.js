// script.js - client-side validation and char counter
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contactForm');
  const msg = document.getElementById('message');
  const charCount = document.getElementById('charCount');

  msg.addEventListener('input', function() {
    charCount.textContent = msg.value.length + ' / 150';
  });

  form.addEventListener('submit', function(e) {
    // basic client-side validation to reduce round-trips
    const name = document.getElementById('name').value.trim();
    const subject = document.getElementById('subject').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = msg.value.trim();

    let errors = [];
    if (!name) errors.push('Name is required');
    if (!subject) errors.push('Subject is required');
    if (!email) errors.push('Email is required');
    else {
      // simple email regex
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!re.test(email)) errors.push('Enter a valid email address');
    }
    if (!message) errors.push('Message is required');
    if (message.length > 150) errors.push('Message cannot exceed 150 characters');

    if (errors.length) {
      e.preventDefault();
      alert(errors.join('\\n'));
      return false;
    }
    // otherwise allow submit; server will still validate
  });
});
