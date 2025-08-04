<?php
include "connect.php";

// Pagination variables
$limit = 5; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page=1;
};
$start_from = ($page-1) * $limit;

// Search variable
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
}

// Count total records for pagination
$count_sql = "SELECT COUNT(*) FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%'";
$count_result = mysqli_query($con, $count_sql);
$row = mysqli_fetch_row($count_result);
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);

// Fetch records with search and pagination
$sql = "SELECT * FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%' ORDER BY id ASC LIMIT $start_from, $limit";
$result = mysqli_query($con, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Crud Operations</title>
</head>
<body>
    <div class="container">
        <h2 class="my-4">User List</h2>
        <form method="GET" action="display.php" class="form-inline mb-3">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by name, email or mobile" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
        </form>
        <button class="btn btn-primary mb-3"><a href="users.php" class="text-light">ADD USER</a></button>
        <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">S.NO</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Mobile</th>
      <th scope="col">PASSWORD</th>
      <th scope="col">Operations</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result) {
      while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $password = $row['password'];
        echo '<tr>
      <th scope="row">'.$id.'</th>
      <td>'.$name.'</td>
      <td>'.$email.'</td>
      <td>'.$mobile.'</td>
      <td>'.$password.'</td>
      <td>
<button class="btn btn-primary"><a href="update.php?update_id='.$id.'" class="text-light">Update</a></button>
<button class="btn btn-danger"><a href="delete.php?delete_id='.$id.'" class="text-light">Delete</a></button>
    </td>
    </tr>';
      }
    } 
    ?>
  </tbody>
</table>

<!-- Pagination links -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <?php 
    for ($i=1; $i<=$total_pages; $i++) { 
        $active = ($i == $page) ? "active" : "";
        $link = "display.php?page=".$i;
        if ($search != "") {
            $link .= "&search=".urlencode($search);
        }
        echo "<li class='page-item $active'><a class='page-link' href='$link'>$i</a></li>";
    }
    ?>
  </ul>
</nav>
        
    </div>
</body>
</html>
