<?php
require "./logic/utility.php";

$posts = getPosts();

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
            <div class="col-7">
                <form method="POST" action="insert.php">
                    <div class="form-group">
                        <textarea class="form-control" name="review" cols="10" rows="10"></textarea>
                    </div>
                    <button type="submit" name="submit_post" class="btn px-4 primary-bg">Submit</button>
                </form>
            </div>
            <!-- <div class="col-5">
                <div class="sentiment-options">
                    <div class="options-container">
                        <button class="btn primary-bg" onclick="submitfunc('good')" style="width:245px;">
                            <form action="" method="POST">
                                <span>Good</span>
                                <input type="hidden" name="good">
                            </form>
                        </button>
                        <button class="btn primary-bg ml-4" onclick="submitfunc('negative')" style="width:245px;">
                            <form action="" method="post">
                                <span>negative</span>
                                <input type="hidden" name="negative">
                            </form>
                        </button>
                    </div>
                    <div class="options-container mt-3">
                        <button class="btn primary-bg" onclick="submitfunc('neutral')" style="width:245px;">
                            <form action="" method="post">
                                <span>neutral</span>
                                <input type="hidden" name="neutral">
                            </form>
                        </button>
                        <button class="btn primary-bg ml-4" onclick="submitfunc()" style="width:245px;">
                            <form action="" method="post">
                                <span>Awesome</span>
                                <input type="hidden" name="Awesome">
                            </form>
                        </button>
                    </div>
                    <div class="options-container mt-3">
                        <button class="btn primary-bg" onclick="submitfunc('poor')" style="width:245px;">
                            <form action="" method="post">
                                <span>Poor</span>
                                <input type="hidden" name="Poor">
                            </form>
                        </button>
                        <button class="btn primary-bg ml-4" onclick="submitfunc('useless')" style="width:245px;">
                            <form action="" method="post">
                                <span>Useless</span>
                                <input type="hidden" name="Useless">
                            </form>
                        </button>
                    </div>
                </div>
            </div> -->
            <?php for ($i = 0; $i < count($posts); $i++) { ?>
                <div class="col-7 py-4 mt-5 sentiment-stats">
                    <div class="mb-2">
                        <span style="color: #603984;font-weight:400;"><?php echo $posts[$i]['text'] ?></span>
                    </div>
                    <div class="options-container">
                        <button class="btn primary-bg my-1 stats-btn" onclick="submitform('positive_<?php echo $posts[$i]['id'] ?>')">
                            <span>Positive</span>
                            <span class="ml-1 p-1 stats-count""><?php echo count(vote('positive', $posts[$i]['id'])) ?></span>
                        <form id="positive_<?php echo $posts[$i]['id'] ?>" action="insert.php" method="post">
                                <input type="hidden" name="vote" value="positive_<?php echo $posts[$i]['id'] ?>">
                                </form>
                        </button>
                        <button class=" btn primary-bg my-1 stats-btn" onclick="submitform('neutral_<?php echo $posts[$i]['id'] ?>')">
                            <span>Neutral</span>
                            <span class="ml-1 p-1 stats-count""><?php echo count(vote('neutral', $posts[$i]['id'])) ?></span>
                                <form action="insert.php" method="post" id="neutral_<?php echo $posts[$i]['id'] ?>">
                                <input type="hidden" name="vote" value="neutral_<?php echo $posts[$i]['id'] ?>">
                                </form>
                        </button>
                        <button class=" btn primary-bg my-1 stats-btn" onclick="submitform('negative_<?php echo $posts[$i]['id'] ?>')">
                            <span>Negative</span>
                            <span class="ml-1 p-1 stats-count""><?php echo count(vote('negative', $posts[$i]['id'])) ?></span>
                            <form id="negative_<?php echo $posts[$i]['id'] ?>" action="insert.php" method="post">
                                <input type="hidden" name="vote" value="negative_<?php echo $posts[$i]['id'] ?>">
                                </form>
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src=" https://code.jquery.com/jquery-3.5.1.min.js"> </script>
    <script src="js/custom.js"></script>
</body>

</html>