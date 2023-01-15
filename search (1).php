<?php
session_start();
require_once('dbconnect.php');
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eden's Bistro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/blog.css" rel="stylesheet">
  </head>
  <body>
    
<div class="container">
  <header class="blog-header lh-1 py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a href='index.php'><img src="images/logo.PNG" class="rounded float-left" alt="logo" style="width: 20%"></a>
      </div>
      <div class="col-4 d-flex flex-row justify-content-end align-items-center">
      <form name="menuSearch" method="post" action="search.php" class="form-inline d-flex flex-row px-4">
        <input name="searchField" id="sf" class="form-control mr-sm-2" type="text" placeholder="Search the Menu" aria-label="Search">
        <button name="searchButton" id="sb" class="btn btn-outline-success my-2 my-sm-0" type="submit" value="search">Search</button>
      </form>
        <a class="btn btn-sm btn-outline-secondary" href="/login/register.php">Sign up</a>
      </div>
    </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <a class="p-2 link-secondary" href="index.php">Home</a>
      <a class="p-2 link-secondary" href="menu.php">Menu</a>
      <a class="p-2 link-secondary" href="/events/index.php">Events</a>
      <a class="p-2 link-secondary" href="/login/register.php">Registration</a>
      <a class="p-2 link-secondary" href="/blogs/index.php">Blogs</a>
    </nav>
  </div>
</div>

<main class="container">
  <div class="row g-5">
    <div class="col-md-8">
      <article class="blog-post">
        <h2 class="blog-post-title mb-1">Search Result</h2>
        <p>Below are food we offer that you might like:</p>
        <hr>
        <?php
            $keyword = $_POST["searchField"];
            $tableArray = array("breakfast", "Lunch", "Dinner", "Sides", "Desserts", "Drinks");
            for ($x = 0; $x <= 4; $x++) {
                $table = $tableArray[$x];
                Print "    <table class=\"table\">";
                Print "      <thead>";
                Print "        <tr>";
                Print "          <th>$table</th>";
                Print "          <th>Price</th>";
                Print "        </tr>";
                Print "      </thead>";
                Print "      <tbody>";
                $sql = "SELECT itemName, itemPrice FROM $table WHERE itemName LIKE \"%$keyword%\";";
                $conn_stmt = $conn->prepare($sql);
                if($conn_stmt->execute()>0){
                    $conn_stmt->bind_result($name,$price);
                    while ($conn_stmt->fetch()){
                      Print "        <tr>";
                        Print "         <td>$name</td>";
                        Print "          <td>$price</td>";
                        Print "        </tr>";
                    }
                }
                Print "      </tbody>";
                Print "    </table>";
              }
        ?>
        <p>If there is no result. We might not have what you search for.  Please try another term or click <a href="http://cis431restaurant.rf.gd">here</a>.</p>
      </article>
    </div>
    <div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4 class="fst-italic">About Us</h4>
          <p class="mb-0">Eden's Bistro is a state of the art Cafe featuring classic meals for any time of the day. Our space has:</p>
          <ul class="">
            <li class="">&nbsp;30 seat party room</li>
            <li class="">&nbsp;25 seat coffee house w/ stage</li>
            <li class="">&nbsp;Outdoor stage w/ dynamic seating</li>
          </ul>
          <p class="mb-0">Stop by or sign up to create a reservation.</p>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Blogs</h4>
          <ol class="list-unstyled mb-0">
            <li><a href="blogs/index.php">Go to Featured</a></li>
          </ol>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Follow us on</h4>
          <ol class="list-unstyled">
            <li><a href="../#">Instagram</a></li>
            <li><a href="../#">Twitter</a></li>
            <li><a href="../#">Facebook</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

</main>
<div class="container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">&copy; 2022 Eden from The Rock, Inc</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
    </a>

    <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Home</a></li>
        <li class="nav-item"><a href="menu.php" class="nav-link px-2 text-muted">Menu</a></li>
        <li class="nav-item"><a href="/events/index.php" class="nav-link px-2 text-muted">Events</a></li>
        <li class="nav-item"><a href="/login/register.php" class="nav-link px-2 text-muted">Registration</a></li>
        <li class="nav-item"><a href="/blogs/index.php" class="nav-link px-2 text-muted">Blogs</a></li>
    </ul>
    </footer>
    </div>
  </body>
</html>