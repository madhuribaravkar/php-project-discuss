<div class="container">

    <div class="row">
        <div class="col-8">
            <h1 class="heading">Questions</h1>
            <?php
            include("./common/db.php");

            // Set variables if they exist in the GET request and escape them for safety
            $cid = isset($_GET['c-id']) ? intval($_GET['c-id']) : null;
            $uid = isset($_GET['u-id']) ? $conn->real_escape_string($_GET['u-id']) : null;
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : null;

            // Build query based on parameters
            if ($cid) {
                $query = "SELECT * FROM questions WHERE category_id = $cid";
            } else if ($uid) {
                $query = "SELECT * FROM questions WHERE user_id = '$uid'";
            } else if (isset($_GET["latest"])) {
                $query = "SELECT * FROM questions ORDER BY id DESC";
            } else if ($search) {
                $query = "SELECT * FROM questions WHERE `title` LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM questions";
            }

            // Execute query and display results
            $result = $conn->query($query);
            foreach ($result as $row) {
                $title = $row['title'];
                $id = $row['id'];
                echo "<div class='row question-list'>
                    <h4 class='my-question'><a href='?q-id=$id'>$title</a>";
                echo $uid ? "<a href='./server/requests.php?delete=$id'>Delete</a>" : NULL;
                echo "</h4></div>";
            }
            ?>
        </div>
        <div class="col-4">
            <?php include('categorylist.php'); ?>
        </div>
    </div>
</div>
