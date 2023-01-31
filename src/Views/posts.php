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
    <div class="container border p-4 my-4">
      <h3 class="text-center mb-4">Posts Section</h3>
      <form style="max-width: 200px;">
        <select name="filter" id="filter" class="form-select">
          <option value="all">All</option>
          <option value="my-posts">My posts</option>
        </select>
      </form>
      <div class="posts mt-4">
        <?php
        use \App\Controllers\PostController;

        $controller = new PostController();

        $posts = NULL;
        if(!isset($_COOKIE['selected']) or $_COOKIE['selected'] === 'all'){
          $posts = $controller->posts();
        }
        else{
          $posts = $controller->userPosts();
        }

        if(sizeof($posts) > 0){
          foreach($posts as $p){?>
            <div class="post border bg-light p-2 mt-4">
              <h6>Title: <?=$p->getTitle();?></h6>
              <p>Author: <?=$p->getUser()->getName();?></p>
              <p>Content: <a href="/post/show/<?=$p->getId();?>"><?=substr($p->getText(), 0, 20);?>...</a></p>
              <small>Date: <?=$p->getDate();?></small>
              <?php
              if($_SESSION['USER_ID'] == $p->getUser()->getId()){
                $id = $p->getId();
                echo '<a href="/removepost/'.$id.'" class="float-end text-danger">Remove</a>';
              }
              ?>
            </div>
          <?php }
        }
        ?>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if(!Cookies.get('selected')){
        Cookies.set('selected', 'all');
      }
      const value = Cookies.get('selected');
      const option = document.querySelector(`[value=${value}]`);
      option.setAttribute('selected', '');
    });

    const select = document.querySelector('#filter');
    select.addEventListener('change', (e) => {
      const oldOption = document.querySelector(`[value=${Cookies.get('selected')}]`);
      oldOption.removeAttribute('selected');

      const value = e.target.value;
      const newOption = document.querySelector(`[value=${value}]`);
      newOption.setAttribute('selected', '');
      Cookies.set('selected', value);

      window.location.href = '/posts';
    });
  </script>

</body>
</html>
