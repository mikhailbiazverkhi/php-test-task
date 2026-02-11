const API = 'http://localhost/php-test/api';

$(function () {

  const currentPage = window.location.pathname.split('/').pop();

  // LOGIN
  if (currentPage === 'signin.html') {
    $('#loginBtn').click(() => {
      const email = $('#email').val();
      const password = $('#password').val();
      if (!email || !password) { $('#error').text('Please enter email and password'); return; }

      $.ajax({
        url: API + '/login',
        method: 'POST',
        xhrFields: { withCredentials: true },
        data: { email, password },
        success: () => { location.href = 'profile.html'; },
        error: (xhr) => { $('#error').text(xhr.responseJSON?.error || 'Login failed'); }
      });
    });
  }

  // REGISTER
  if (currentPage === 'signup.html') {
    $('#registerBtn').click(() => {
      const name = $('#name').val();
      const email = $('#email').val();
      const password = $('#password').val();
      const birth_date = $('#birth_date').val();
      if (!name || !email || !password || !birth_date) { $('#error').text('All fields required'); return; }

      $.ajax({
        url: API + '/register',
        method: 'POST',
        xhrFields: { withCredentials: true },
        data: { name, email, password, birth_date },
        success: () => { location.href = 'signin.html'; },
        error: (xhr) => { $('#error').text(xhr.responseJSON?.error || 'Register failed'); }
      });
    });
  }

  // PROFILE PAGE
  if (currentPage === 'profile.html') {
    // Load profile
    $.ajax({
      url: API + '/profile',
      method: 'GET',
      xhrFields: { withCredentials: true },
      success: (res) => {
        $('#name').val(res.user.name);
        $('#email').val(res.user.email);
        $('#birth_date').val(res.user.birth_date);
      },
      error: () => {
        location.href = 'signin.html';
      }
    });

    //UPDATE
    $('#updateBtn').click(() => {
      const data = {
        name: $('#name').val().trim(),
        birth_date: $('#birth_date').val(),
        password: $('#password').val()
      };

      $.ajax({
        url: API + '/profile',
        method: 'PUT',
        xhrFields: { withCredentials: true },
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: () => { $('#msg').text('Profile updated'); },
        error: (xhr) => { $('#msg').text(xhr.responseJSON?.error || 'Update failed'); }
      });
    });

    // LOGOUT
    $('#logoutBtn').click(() => {
      $.ajax({
        url: API + '/logout',
        method: 'POST',
        xhrFields: { withCredentials: true },
        success: () => { location.href = 'signin.html'; }
      });
    });

    // DELETE
    $('#deleteBtn').click(() => {
      if (!confirm('Are you sure?')) return;
      $.ajax({
        url: API + '/profile',
        method: 'DELETE',
        xhrFields: { withCredentials: true },
        success: () => { location.href = 'signup.html'; }
      });
    });
  }

});