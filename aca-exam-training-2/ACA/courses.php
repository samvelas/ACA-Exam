
<?php
include "components/header.php";
define("ITEMS_PER_PAGE", 3);

$courses = [];
$tempArray = [];
$message = '';
session_start();
$currentPage = 1;

if (isset($_GET['title']) && isset($_GET['tutor'])) {
    $title = ($_GET['title']);
    $course = ($_GET['tutor']);
    if ($title != '' && $course != '') {
        $edit_file = fopen("files/cources.txt", "a");
        $l = $title . " | " . $course . "\n";
        fwrite($edit_file, $l);
        fclose($edit_file);
    }
    $_SESSION['message'] = "<span>Added </span><strong>" . $title . "</strong><span> course which tutor is </span><strong>" . $course . "</strong>";
}

$tempFile = fopen("files/cources.txt", "r+") or die("Can't open file");

while (!feof($tempFile)){
    $line = fgets($tempFile);
    if ($line != '') {
        $row = explode("|", $line);
        $courses[] = $row;
    }
}

$size = count($courses);
fclose($tempFile);




if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
}

if (isset($_GET['del'])){
    $del = $_GET['del'];
    $_SESSION['message'] = "<span>Deleted </span><strong>" . $courses[$del][0] . "</strong><span> course</span>";
    array_splice($courses, $del, 1);
    $edit_file = fopen("files/cources.txt", "w");
    $size--;
    foreach ($courses as $course){
        $l = $course[0] . "|" . $course[1];

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
            <form action="courses.php">
                <h2>Add course</h2>
                <input id="name" class="form-control" name="title" placeholder="Course title">
                <input class="form-control" name="tutor" placeholder="Lecturer">
                <br>
                <button class="btn btn-info btn-md" type="submit">Add</button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-md-2">
            <h1 class="page-header">Menu</h1>
            <div class="list-group">
                <a class="list-group-item disabled">Courses</a>
                <a href="index.php" class="list-group-item">Students</a>
            </div>
            <div class="well"><?php echo $message; ?></div>
        </div>
        <div class="col-md-offset-1 col-md-8">
            <h1 class="page-header">Courses</h1>
            <button class="btn btn-success btn-lg" id="myBtn" type="submit">Add<span style="margin-left: 15px" class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Lecturer</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <?php
                for ($i = $start - 1; $i < $start + $limit; $i++) {
                    echo "<tr>";
                    echo "<td>" . ($i + 1) . "</td>";
                    echo "<td class='sm'>" . $courses[$i][0] . "</td>";
                    echo "<td class='sm'>" . $courses[$i][1] . "</td>";
                    echo '<td class="sm"><a class="btn btn-danger btn-sm" href="http://localhost/aca-exam-training-2/ACA/courses.php?page=' . $currentPage . '&del=' . $i . '">Delete</a></td>';
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

                        echo '<li class="' . $style . '"><a href="http://localhost/aca-exam-training-2/ACA/courses.php?page=' . $i . '">' . $i . '</a></li>';
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