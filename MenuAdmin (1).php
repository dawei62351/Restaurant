<?php
session_start();
require_once('../dbconnect.php');
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Menu Admin Page</title>
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
        <a href='../index.php'><img src="../images/logo.PNG" class="rounded float-left" alt="logo" style="width: 20%"></a>
      </div>
      <div class="col-4 d-flex flex-row justify-content-end align-items-center">
      <form name="menuSearch" method="post" action="../search.php" class="form-inline d-flex flex-row px-4">
        <input name="searchField" id="sf" class="form-control mr-sm-2" type="text" placeholder="Search the Menu" aria-label="Search" required>
        <button name="searchButton" id="sb" class="btn btn-outline-success my-2 my-sm-0" type="submit" value="search">Search</button>
      </form>
        <a class="btn btn-sm btn-outline-secondary" href="../login/index.php">Sign up</a>
      </div>
    </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <a class="p-2 link-secondary" href="../index.php">Home</a>
      <a class="p-2 link-secondary" href="../menu.php">Menu</a>
      <a class="p-2 link-secondary" href="../events/index.php">Events</a>
      <a class="p-2 link-secondary" href="../login/register.php">Registration</a>
      <a class="p-2 link-secondary" href="../blogs/index.php">Blogs</a>
    </nav>
  </div>
</div>
<main class="container">
    <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 fst-italic">All Menu Items</h1>
    </div>
  </div>
    
    <p align="center">here are all the items from our restaurant menu, click change or delete button to alter the menu or delete the item from our database.<br>You can insert a new item using the insert form at the bottom of the page.</p>
	<hr>
    <form action="" method="post" name="tables">
        <table align="center" board="1px" cellspacing="0px" width="800px">
            <tr><th>itemId</th><th>itemName</th><th>itemPrice</th><th>Action</th></tr>
            <?php
            $tableArray = array("breakfast", "Lunch", "Dinner", "Sides", "Desserts", "Drinks");
            for ($x = 0; $x <= 4; $x++) {
                $table = $tableArray[$x];
                $result = mysqli_query($conn,"select itemId, itemName, itemPrice from $table");
                while ($row = mysqli_fetch_array($result)){
                    Print "<tr align=\"center\">";
                    Print "<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>
                    <td>
                    <input type=\"submit\" name=\"change$row[0]\" value=\"change\" />
                    <input type=\"submit\" name=\"delete$row[0]\" value=\"delete\">
                    </td>";
                    Print "</tr>";
                    if(!empty($_POST["change$row[0]"])){
                        print "<tr align=\"center\">";
                        print "<td>$row[0]</td>
                        <td><input type=\"text\" name=\"changeName\" /></td>
                        <td><input type=\"text\" name=\"changePrice\" /></td>
                        <td><input type=\"submit\" name=\"changeSubmit$row[0]\" value=\"Confirm Change\"/></td>";
                        print "</tr>";
                    }
                    if (!empty($_POST["changeSubmit$row[0]"])) {
                        $changeName = $_POST["changeName"];
                        $changePrice = $_POST["changePrice"];
                        mysqli_query($conn,"update $table set itemName=\"$changeName\", itemPrice=\"$changePrice\" where itemId=\"$row[0]\"");
                        header("location:#");
                    }
                    if(!empty($_POST["delete$row[0]"])){
                        mysqli_query($conn,"delete from $table where itemId=\"$row[0]\"");
                        header("location:#");
                    }
                }
            }
            ?>
        </table>
<br><br>
<hr><br>

        <form method="post" action="MenuAdmin.php" name="insertForm">
        <h1 align="center">Insert New Menu Item</h1> 
        <p align="center">Table:<input type="text" name="table" /></p>
        <p align="center">itemId:<input type="text" name="itemId" /></p>
        <p align="center">itemName:<input type="text" name="itemName" /></p>
        <p align="center">itemPrice:<input type="text" name="itemPrice" /></p>
        <p align="center"><input type="submit" name="insert" value="insert" /></p>
        </form>
	    <?php
            if (!empty($_POST["insert"])){
                $table =$_POST["table"];
                $itemId =$_POST["itemId"];
                $itemName =$_POST["itemName"];
                $itemPrice =$_POST["itemPrice"];
                mysqli_query($conn,"insert $table (itemId,itemName,itemPrice) value (\"$itemID\",\"$itemName\",$itemPrice)");
                header("location:#");
            }
	    ?>
    </form>
    <hr>
</main>
    </body>
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">&copy; 2022 Eden from The Rock, Inc</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
    </a>

    <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="../index.php" class="nav-link px-2 text-muted">Home</a></li>
        <li class="nav-item"><a href="../menu.php" class="nav-link px-2 text-muted">Menu</a></li>
        <li class="nav-item"><a href="../events/index.php" class="nav-link px-2 text-muted">Events</a></li>
        <li class="nav-item"><a href="../login/register.php" class="nav-link px-2 text-muted">Registration</a></li>
        <li class="nav-item"><a href="../blogs/index.php" class="nav-link px-2 text-muted">Blogs</a></li>
    </ul>
    </footer>
</html>