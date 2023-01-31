<?php
require __DIR__ . '/../../vendor/autoload.php';

use \App\Classes\Session;

Session::start();
Session::validate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/partials/head.php'; ?>
  <title>Add post</title>
</head>
<body>

  <?php include __DIR__ . '/partials/blognavbar.php'; ?>
  <?php include __DIR__ . '/partials/welcome.php'; ?>

  <main style="max-width: 750px;">
    <div class="container border mt-4 p-4">
      <div id="dialog"></div>
      <h3 class="mb-3">Fill out the form below</h3>
      <form>
        <div>
          <label for="title">Title</label>
          <input type="text" name="title" id="title" class="form-control" required minlength="5">
        </div>
        <div>
          <label for="text">Text</label>
          <textarea name="text" id="text" cols="30" rows="8" class="form-control" required minlength="20"></textarea>
        </div>
        <div>
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
        title: document.querySelector('#title').value,
        text: document.querySelector('#text').value
      });

      const init = {
        method: 'POST',
        headers: new Headers({
          'Content-type': 'application/json',
          'Content-length': body.length
        }),
        body
      }

      fetch('http://localhost/addpost', init).then(async (res) => {
        if(res.status === 400){
          const data = await res.json();
          const dialog = document.querySelector('#dialog');
          dialog.classList.add('alert', 'alert-danger');
          switch(data.data){
            case 'INVALID_DATA':
              dialog.innerHTML = 'Data is invalid!';
              break;
            default:
              break;
          }
          return;
        }
        window.location.href = '/posts';
      });
    });
  </script>

</body>
</html>
