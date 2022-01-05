<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    
    
    
    <title>My Notes</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/Reminiscence/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Reminiscence/home.php">Refresh</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <?php
            $server_name = "localhost";
            $username = "root";
            $password = "";
            $database = "mynotes";

            $conn = mysqli_connect($server_name, $username, $password, $database);

            if (!$conn)
            {
                die("connection failed". mysqli_connect_error());
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $note_title = $_POST['title'];
                $note_details = $_POST['details'];

                if (!empty ($note_title) && !empty ($note_details))
                {
                    $my_sql = "INSERT INTO `contents` (`title`, `details`) VALUES ('$note_title', '$note_details')";
                    $result = mysqli_query($conn, $my_sql);


                    if ($result)
                    {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                        <strong>Success!</strong> Your note added successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }else
                    {
                        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Error!</strong> Something went wrong :(
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }else
                {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Invalid Input!</strong> Please add both note and details carefully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
        ?>


    <div class="container my-3">
        <form action="/Reminiscence/home.php" method="post">
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Note Title:</label>
                <input type="text" class="form-control" id="exampleInputTitle" name="title"
                    aria-describedby="emailHelp" />
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="details" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Note</button>
        </form>
    </div>

    <div class="container my-4">

        <table class="table" id = "myTable">
            <thead>
                <tr>
                    <th scope="col">Sl No</th>
                    <th scope="col">Note Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `contents`";
                $result = mysqli_query($conn, $sql);
                $SlNo = 0;
                while ($row = mysqli_fetch_assoc($result))
                {
                    $SlNo += 1;
                    echo "<tr>
                        <th scope='row'>". $SlNo ."</th>
                        <td>". $row['title'] ."</td>
                        <td>". $row['details'] ."</td>
                        <td>@actions</td>
                        </tr>";
                     } ?>
            </tbody>
        </table>
    </div>


    <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
        
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
        $('#myTable').DataTable();
        } );
    </script>
</body>

</html>