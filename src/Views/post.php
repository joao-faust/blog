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
  <title>Register</title>
</head>
<body>

  <?php include __DIR__ . '/partials/blognavbar.php'; ?>
  <?php include __DIR__ . '/partials/welcome.php'; ?>

  <main class="px-3" style="max-width: 1200px;">
    <div class="container border p-4 mt-4">
      <h3 class="text-center mb-4">Posts Section</h3>
      <?php
      use \App\Controllers\PostController;

      $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

      $controller = new PostController();
      $post = $controller->postById($id);
      if($post->getTitle() != NULL){?>
        <div class="posts mt-4">
          <div class="post border bg-light p-2 mt-4">
            <h6>Title: <?=$post->getTitle();?></h6>
            <p>Author: <?=$post->getUser()->getName();?></p>
            <p><?=nl2br($post->getText());?></p>
            <p><small>Date: <?=$post->getDate();?></small></p>
          </div>
        </div>
      <?php } ?>
      <a href="/posts" class="d-block mt-3">Go back</a>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
  <script>
  </script>

</body>
</html>
