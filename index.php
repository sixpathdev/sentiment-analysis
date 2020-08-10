<?php
require "./logic/utility.php";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$posts = getPosts($page);
if (count($posts) < 1) {
    echo "<script>window.history.back();</script>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sentiment Analysis</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container center-form">
        <div class="row">
        <div class="col-7 mb-3">
        <span class="d-block h3 text-center">Sentiment Analysis</span>
        </div>
            <div class="col-7">
                <form method="POST" action="insert.php">
                    <div class="form-group">
                        <textarea class="form-control" name="review" cols="10" rows="10"></textarea>
                    </div>
                    <button type="submit" name="submit_post" class="btn px-4 primary-bg">Submit</button>
                </form>
                <?php if (isset($_SESSION['error'])) { ?>
                    <div id="alert" class="alert mt-3 alert-danger">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        echo "<script>setTimeout(function(){ document.getElementById('alert').style.display='none' },1400)</script>";
                        ?>
                    </div>
                <?php } ?>
            </div>
            <?php for ($i = 0; $i < count($posts); $i++) { ?>
                <div class="col-7 py-1 pl-4 mt-4 sentiment-stats">
                    <div class="mb-2">
                        <span style="color: #603984;font-weight:400;"><?php echo $posts[$i]['text'] ?></span>
                    </div>
                    <div class="options-container">
                        <span style="font-weight:400;" class="<?php echo $posts[$i]['sentiment'] == 'negative' ? 'text-danger' : 'text-success' ?>"><?php echo $posts[$i]['sentiment'] ?></span>
                    </div>
                </div>
            <?php } ?>
            <div class="col-7 mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination float-right">
                        <?php if (isset($_GET['page'])  && $_GET['page'] == 2) { ?>
                            <li class="page-item"><a class="page-link" style="font-weight: 400;" href="/">Previous</a></li>
                        <?php } elseif (!isset($_GET['page'])) { ?>
                            <li class="page-item" style="display: none;"><a class="page-link" style="font-weight: 400;" href="/">Previous</a></li>
                        <?php } else { ?>
                            <li class="page-item"><a class="page-link" style="font-weight: 400;" href="<?php echo isset($_GET['page']) ? '?page=' . (int)($_GET['page'] - 1) : '?page=2' ?>">Previous</a></li>
                        <?php } ?>
                        <li class="page-item"><a class="page-link" style="font-weight: 400;" href="<?php echo isset($_GET['page']) ? '?page=' . (int)($_GET['page'] + 1) : '?page=2' ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src=" https://code.jquery.com/jquery-3.5.1.min.js"> </script>
    <script src="js/custom.js"></script>
</body>

</html>