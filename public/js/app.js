const API = '/api';

$(function () {

  $('#loginBtn').click(async () => {
    try {
      await $.post(API + '/login', {
        email: $('#email').val(),
        password: $('#password').val()
      });
      location.href = 'profile.html';
    } catch (e) {
      $('#error').text(e.responseJSON?.error || 'Login failed');
    }
  });

$('#registerBtn').click(async () => {
  try {
    await $.post(API + '/register', {
      name: $('#name').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      birth_date: $('#birth_date').val()
    });
    location.href = 'signin.html';
  } catch (e) {
    $('#error').text(e.responseJSON?.error || 'Register failed');
  }
});

  if (location.pathname.includes('profile.html')) {
    $.get(API + '/profile')
      .done(res => {
        $('#name').val(res.user.name);
        $('#email').val(res.user.email);
        $('#birth_date').val(res.user.birth_date);
      })
      .fail(() => location.href = 'signin.html');
  }

  $('#updateBtn').click(async () => {
    try {
      await $.ajax({
        url: API + '/profile',
        method: 'PUT',
        data: {
          name: $('#name').val(),
          birth_date: $('#birth_date').val(),
          password: $('#password').val()
        }
      });
      $('#msg').text('Profile updated').addClass('text-success');
    } catch (e) {
      $('#msg').text(e.responseJSON?.error || 'Update failed').addClass('text-danger');
    }
  });

  $('#logoutBtn').click(async () => {
    await $.post(API + '/logout');
    location.href = 'index.html';
  });

  $('#deleteBtn').click(async () => {
    if (!confirm('Are you sure?')) return;
    await $.ajax({ url: API + '/profile', method: 'DELETE' });
    location.href = 'index.html';
  });

});
