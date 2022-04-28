<?php

$insert = false;
$update = false;
$delete = false;
// CONNECTION TO THE DATABASE
$servername = "sql5.freesqldatabase.com";
$username = "sql5487865";
$password = "4pZf6DHPRZ";
$database = "sql5487865";

$con = mysqli_connect($servername, $username, $password, $database);
//Check if the connection established
if(!$con){
  die("Sorry we failed to connect : ".mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno`=$sno";
  $result = mysqli_query($con,$sql);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    // Update the record
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];
  
    $sql = "UPDATE `notes` SET `title` = '$title', `description`='$description' WHERE `notes`.`sno` = $sno;";
    $result = mysqli_query($con,$sql);
    if($result){
      $update = true;
    }
    else{
      echo "The note was not able to be added because of the error --> ". mysqli_error($con);
    }
  }
  else{
    $title = $_POST['title'];
    $description = $_POST['description'];
  
    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($con,$sql);
    if($result){
      $insert = true;
    }
    else{
      echo "The note was not able to be added because of the error --> ". mysqli_error($con);
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    

    <title>CRUD application</title>
  </head>
  <body>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/index.php" method="post">
      <div class="modal-body">
          <input type="hidden" id="snoEdit" name="snoEdit">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input
            type="text"
            class="form-control"
            id="titleEdit"
            name = "titleEdit"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Describe</label>
          <div class="form">
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>
    <div class="navbar_crud">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">iNotes</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            </ul>
            <form class="d-flex">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-outline-success" type="submit">
                Search
              </button>
            </form>
          </div>
        </div>
      </nav>
    </div>
    <?php 
    if($insert == true){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Congrats!!</strong> Your note has been added succesfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if($update == true){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Congrats!!</strong> Your note has been updated succesfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if($delete == true){
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
      Your note has been deleted successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    ?>
    <div class="container my-4">
      <form action="/index.php" method="post">
        <div class="mb-3">
        <h2>Add a Note</h2>
          <label for="title" class="form-label">Title</label>
          <input
            type="text"
            class="form-control"
            id="title"
            name = "title"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Describe</label>
          <div class="form">
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>
    <div class="container">
      <table class="table table-hover" id="myTable">
        <thead>
          <tr>
            <th scope="col">S No.</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          //fetching the table from the database
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($con, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno++;
            echo "<tr>
            <th scope='row'>$sno</th>
            <td>".$row['title']."</td>
            <td>".$row['description']."</td>
            <td><button class='btn btn-primary edit' id=".$sno.">Edit</button> <button class='btn btn-primary delete' id=d".$row['sno'].">Delete</button></td>
          </tr>";  
          }
          ?>
          
        </tbody>
      </table>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
      } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) =>{
        element.addEventListener("click", (e) =>{
          // console.log("edit ",);
          t = e.target.parentNode.parentNode;
          title = t.getElementsByTagName("td")[0].innerText;
          description = t.getElementsByTagName("td")[1].innerText;
          // console.log(description);
          snoEdit.value = e.target.id;
          titleEdit.value = title;
          descriptionEdit.value = description;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e) =>{
          sno = e.target.id.substr(1,);
          if(confirm("re you sure you want to delete this note!!")){
            console.log("yes");
            window.location = `/index.php?delete=${sno}`;
          }
          else{
            console.log("no");
          }
        })
      })
    </script>
  </body>
</html>
