<?php 

$insert = false;
$update = false;
$delete = false;

// Connect to the database
$server = "localhost";
$user = "root";
$password = "root";
$database = "notes";

// Create a connection
$conn = new mysqli($server, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DELETE Record
if (isset($_GET['delete'])) {
    $sno = $_GET["delete"];
    $sql = "DELETE FROM `notes` WHERE `sno` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sno);
    if ($stmt->execute()) {
        $delete = true;
    }
    $stmt->close();
}

// HANDLE FORM REQUEST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // UPDATE Record
        $title = htmlspecialchars($_POST["titleEdit"]);
        $description = htmlspecialchars($_POST["descriptionEdit"]);
        $id = $_POST["snoEdit"];

        $sql = "UPDATE `notes` SET `title` = ?, `description` = ? WHERE `sno` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $description, $id);
        if ($stmt->execute()) {
            $update = true;
        }
        $stmt->close();
    } else {
        // INSERT Record
        $title = htmlspecialchars($_POST["title"]);
        $description = htmlspecialchars($_POST["description"]);

        $sql = "INSERT INTO `notes`(`title`, `description`) VALUES(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $title, $description);
        if ($stmt->execute()) {
            $insert = true;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes - Notes taking made easy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>
<body>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3">
                        <label for="titleEdit" class="form-label">Note Title</label>
                        <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                    </div>
                    <div class="mb-3">
                        <label for="descriptionEdit" class="form-label">Note Description</label>
                        <textarea class="form-control" id="descriptionEdit" rows="3" name="descriptionEdit"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>  

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">iNotes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Alerts -->
<?php 
if ($insert) echo "<div class='alert alert-success'>Note inserted successfully!</div>";
if ($update) echo "<div class='alert alert-success'>Note updated successfully!</div>";
if ($delete) echo "<div class='alert alert-success'>Note deleted successfully!</div>";
?>

<!-- Form -->
<div class="container my-4">
    <h2>Add a Note</h2>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Note Description</label>
            <textarea class="form-control" id="desc" rows="3" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
</div>

<!-- Notes Table -->
<div class="container">
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT * FROM notes";
            $result = $conn->query($sql);
            $sno = 0;
            while ($row = $result->fetch_assoc()) {
                $sno++;
                echo "<tr>
                    <th scope='row'>$sno</th>
                    <td>".htmlspecialchars($row['title'])."</td>
                    <td>".htmlspecialchars($row['description'])."</td>
                    <td>
                        <button class='btn btn-sm btn-primary edit' data-id='{$row['sno']}'>Edit</button>
                        <button class='btn btn-sm btn-danger delete' data-id='{$row['sno']}'>Delete</button>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
let table = new DataTable('#myTable');

document.querySelectorAll('.edit').forEach(button => {
    button.addEventListener('click', (e) => {
        let row = e.target.closest('tr');
        document.getElementById('titleEdit').value = row.children[1].innerText;
        document.getElementById('descriptionEdit').value = row.children[2].innerText;
        document.getElementById('snoEdit').value = e.target.dataset.id;
        $('#editModal').modal('toggle');
    });
});

document.querySelectorAll('.delete').forEach(button => {
    button.addEventListener('click', (e) => {
        if (confirm("Are you sure you want to delete this note?")) {
            window.location = `index.php?delete=${e.target.dataset.id}`;
        }
    });
});
</script>
</body>
</html>
