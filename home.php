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

    <!-- Custom css -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/all.css">

    <!-- Custom web fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    
    
    <title>My Notes</title>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMoadalLabel">Edit your notes </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/Reminiscence/home.php" method="post">
                        <input type="hidden" name="editSlNo" id = "editSlNo">
                        <div class="mb-3">
                            <label for="exampleInputTitle" class="form-label">Note Title:</label>
                            <input type="text" class="form-control" id="edittitle" name="edittitle"
                                aria-describedby="emailHelp" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea class="form-control" id="editdetails" name="editdetails" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="Submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- navbar using bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="notepad.png" alt="" width="30" height="30" class="d-inline-block align-text-top me-1">
            My Notes
            </a>
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
            // connecting with database
            $server_name = "localhost";
            $username = "root";
            $password = "";
            $database = "mynotes";

            $conn = mysqli_connect($server_name, $username, $password, $database);

            if (!$conn)
            {
                die("connection failed". mysqli_connect_error());
            }

            if (isset($_GET['delete']))
            {
                $del_serial = $_GET['delete'];
                // echo "Serial Number is : ".$del_serial;

                $del_sql = "DELETE FROM `contents` WHERE `contents`.`Sl No` = '$del_serial'";
                $result = mysqli_query($conn, $del_sql);
                if ($result)
                    {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                            <strong>Success!</strong> Your note has been deleted successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }
                }
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (isset($_POST['editSlNo']))
                {
                    $Serial = $_POST['editSlNo'];
                    $up_note_title = $_POST['edittitle'];
                    $up_note_details = $_POST['editdetails'];
                    // echo "title: ".$up_note_title ." details: ".$up_note_details . " Serial no ". $Serial;
                    $up_sql = "UPDATE `contents` SET `title` = '$up_note_title', `details` = '$up_note_details' WHERE `contents`.`Sl No` = '$Serial' ";
                    $result = mysqli_query($conn, $up_sql);
                    if ($result)
                    {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                            <strong>Success!</strong> Your note updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }else
                    {
                        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Error!</strong> Something went wrong :( Your note could not updated.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    
                }else
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
                
                
            } 
    ?>

    <!-- Entry Box -->
    <div class="welcome">
        <h1 class="center_text">Welcome to Web Notes</h1>
    </div>
    <div class="container my-3 section_one card shadow-sm p-3 mb-5 bg-body rounded">
        <form action="/Reminiscence/home.php" method="post">
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label"><span class = "text_bold">Note Title</span></label>
                <input type="text" class="form-control" id="exampleInputTitle" name="title"
                    aria-describedby="emailHelp" />
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"><span class="text_bold">Description</span></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="details" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
            <i class="fas fa-download me-1"></i>Save Note</button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="container card my-4">

        <table class="table" id = "myTable">
            <thead>
                <tr>
                    <th class="center_text" scope="col">Sl  No</th>
                    <th class="center_text" scope="col">Note Title</th>
                    <th class="center_text" scope="col">Description</th>
                    <th class="center_text" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `contents`";
                $result = mysqli_query($conn, $sql);
                $serial_no = 0;
                while ($row = mysqli_fetch_assoc($result))
                {
                    $serial_no = $serial_no + 1;
                    echo "<tr>
                        <th class='center_text' scope='row'>". $serial_no ."</th>
                        <td class='center_text' >". $row['title'] ."</td>
                        <td class='center_text' >". $row['details'] ."</td>
                        <td class='center_text' ><button class='edit btn btn-sm btn-primary' id = ". $row['Sl No'] ." >
                        <i class='fas fa-edit me-1'></i> Edit</button> <button class='delete btn btn-sm btn-primary' id = ".$row['Sl No'].">
                        <i class='fas fa-trash-alt me-1'></i> Delete </button></td>
                        </tr>";
                     } ?>
            </tbody>
        </table>
    </div>


    <!-- horizontal line -->
    <hr> 

    <!-- js dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
        
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- data table dependencies -->
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- js for datatable -->
    <script>
        $(document).ready( function () {
        $('#myTable').DataTable();
        } );
    </script>

    <!-- js for edit button -->
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) =>
            {
                console.log("Edit Button Clicked");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName('td')[0].innerText
                descript = tr.getElementsByTagName('td')[1].innerText
                console.log(title, " :: " ,descript)
                edittitle.value = title;
                editdetails.value = descript;
                editSlNo.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle');
                
            })
        })
        // js for delete button
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e)=>
            {
                console.log("Del button clicked");
                serial = e.target.id;
                console.log(e.target.id);
                
                if (confirm("Are you sure to delete this note? It can't be undone if you delete once."))
                {
                    console.log("Yes")
                    window.location = `/Reminiscence/home.php?delete=${serial}`;
                } else
                {
                    console.log("No")
                }
            })
        })
        ;
    </script>

</body>

</html>