<?php
require __DIR__ . '/../../vendor/autoload.php';

use \App\Classes\Session;

Session::start();

if(isset($_SESSION['OWNER_SESSION'])){
  header('Location: /post/add');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/partials/head.php'; ?>
  <title>Login</title>
</head>
<body>

  <?php include __DIR__ . '/partials/usernavbar.php'; ?>

  <main class="px-3" style="max-width: 520px;">
    <div class="container border mt-4 p-4">
      <h3 class="mb-3">Fill out the form below</h3>
      <div id="dialog"></div>
      <form action="" method="POST" autocomplete="off">
        <div>
          <label for="email">E-mail</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="text-center captcha">
          <div><img src="/captcha" alt=""></div>
          <input type="text" name="captcha" id="captcha" placeholder="Captcha" class="form-control" required>
        </div>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
          <a href="/user/add">Don't have an account?</a>
          <button type="submit" class="btn btn-primary">OK</button>
        </div>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
  <script>
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const body = JSON.stringify({
        email: document.querySelector('#email').value,
        password: document.querySelector('#password').value,
        captcha: document.querySelector('#captcha').value
      });

      const init = {
        method: 'POST',
        headers: new Headers({
          'Content-type': 'application/json',
          'Content-length': body.length
        }),
        body
      }

      fetch('http://localhost/makelogin', init).then(async (res) => {
        if(res.status === 400){
          const data = await res.json();
          const dialog = document.querySelector('#dialog');
          dialog.classList.add('alert', 'alert-danger');
          switch(data.data){
            case 'INVALID_DATA':
              dialog.innerHTML = 'Data is invalid!';
              break;
            case 'INVALID_CREDENTIALS':
              dialog.innerHTML = 'Credentials are invalid!';
              break;
            case 'INVALID_CAPTCHA':
              dialog.innerHTML = 'Captcha is invalid!'
            default:
              break;
          }
          return
        }
        window.location.href = '/post/add';
      });
    });
  </script>

</body>
</html>
