<?php
include "components/header.php";

define("ITEMS_PER_PAGE", 3);
$users = [];
session_start();
$tempArray = [];
$currentPage = 1;
$message = '';



if (isset($_GET['first']) && isset($_GET['available'])) {
    $first = ($_GET['first']);
    $cource = ($_GET['available']);
    if($first != '' && $cource != '') {
        $edit_file = fopen("files/info.txt", "a");
        $l = $first . " | " . $cource . "\n";
        fwrite($edit_file, $l);
        fclose($edit_file);
    }
    $_SESSION['message'] = "<span>Added new student to </span><strong>" . $cource . "</strong><span> course.<br> Name: </span><strong>" . $first . "</strong>";
}

$tempFile = fopen("files/info.txt", "r") or die("Can't open file");

while (!feof($tempFile)){
    $line = fgets($tempFile);
    if ($line != '') {
        $row = explode("|", $line);
        $users[] = $row;
    }
}

$size = count($users);
fclose($tempFile);




if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
}

if (isset($_GET['del'])){
    $del = $_GET['del'];
    $_SESSION['message'] = "<span>Deleted student from </span><strong>" . $users[$del][1] . "</strong><span>course.<br> Name: </span><strong>" . $users[$del][0] . "</strong>";
    array_splice($users, $del, 1);
    $edit_file = fopen("files/info.txt", "w");
    $size--;
    foreach ($users as $user){
            $l = $user[0] . "|" . $user[1];

        fwrite($edit_file, $l);
    }
    fclose($edit_file);
}

$totalPageCount = ceil($size / ITEMS_PER_PAGE);

$start = ($currentPage - 1) * ITEMS_PER_PAGE + 1;
$limit = ITEMS_PER_PAGE;

if ($start + $limit > $size) {
    $limit = $size - $start;
}


if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
    session_destroy();
}
?>
<div class="container-fluid">

    <div id="myModal" class="modal">

        <!-- Modal content -->

        <div class="modal-content">
            <span class="close">x</span>
            <form action="index.php">
                <h2>Add student</h2>
                <input id="name" class="form-control" name="first" placeholder="First Name">
                <select name="available" class="form-control">
                    <?php
                    $cources = [];
                    $tempFile = fopen("files/cources.txt", "r+") or die("Can't open file");
                    while (!feof($tempFile)){
                        $line = fgets($tempFile);
                        if ($line != '') {
                            $row = explode("|", $line);
                            $cources[] = $row[0];
                        }
                    }
                    $cources = array_unique($cources);
                    foreach ($cources as $cource){
                        echo '<option>';
                        echo $cource;
                        echo '</option>';
                    }
                    ?>

                </select><br>

                <button class="btn btn-info btn-md" type="submit">Add</button>
            </form>
        </div>

    </div>
    <div class="row">

        <div class="col-md-2">
            <h1 class="page-header">Menu</h1>

            <div class="list-group">
                <a href="courses.php" class="list-group-item">Cources</a>
                <a class="list-group-item disabled">Students</a>
            </div>
            <div class="well"><?php echo $message; ?></div>
        </div>
        <div class="col-md-offset-1 col-md-8">
            <h1 class="page-header">Students</h1>
            <button class="btn btn-success btn-lg" id="myBtn" type="submit">Add<span style="margin-left: 15px" class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Student</th>
                    <th>Cource</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                <?php
                for ($i = $start - 1; $i < $start + $limit; $i++) {
                    echo "<tr>";
                    echo "<td>" . ($i + 1) . "</td>";
                    echo "<td>" . $users[$i][0] . "</td>";
                    echo "<td>" . $users[$i][1] . "</td>";
                    echo '<td><a class="btn btn-danger btn-sm" href="http://localhost/aca-exam-training-2/ACA/index.php?page=' . $currentPage . '&del=' . $i . '">Delete</a></td>';
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPageCount; $i++) {
                        $style = '';
                        if ($i == $currentPage) {
                            $style = "active";
                        }

                        echo '<li class="' . $style . '"><a href="http://localhost/aca-exam-training-2/ACA/index.php?page=' . $i . '">' . $i . '</a></li>';

                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php
include  "components/footer.php";
?>