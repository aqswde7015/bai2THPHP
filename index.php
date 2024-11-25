<!-- <?php
$file_path = 'data.txt';
$List = [];
$id = 0;
// $id = $_GET["id"];
if(isset($_GET["id"])){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    }

    $id = $_GET["id"];
// Kiểm tra file có tồn tại không
}   
if (file_exists($file_path)) {
    // Đọc nội dung file
    $content = file_get_contents($file_path);

    // Tách nội dung thành từng dòng
    $lines = explode("\n", $content);

    // Hiển thị nội dung dạng HTML
    echo "<html><head><title>Quiz Display</title></head><body>";
    echo "<h1>Quiz Questions</h1>";
// Duyệt từng dòng và hiển thị
// print_r($List);
foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) continue;

    if (strpos($line, 'ANSWER:') === 0) {
        $question['answer'] = trim(substr($line, 7));
        $questions[] = $question;
        $question = null;
    } elseif (ctype_upper($line[0]) && $line[1] === '.') {
        $question['options'][] = $line;
    } else {
        $question = ['question' => $line, 'options' => []];
    }
}
}  
// Xử lý kết quả khi người dùng gửi bài
// $currentQuestion = isset($_POST['answer']);
$score = isset($_POST['score']) ? (int)$_POST['score'] : 0;
$correctAnswer = $questions[$id]['answer'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected = $_POST['answer'];
    $curr = $selected;
    $score = $_POST['score'];
    if ($selected === $correctAnswer) {
        $score++;
    }
    echo($score);
}

// Kiểm tra câu trả lời đúng
// Chuyển sang câu hỏi tiếp theo
echo($correctAnswer);
echo($score);
// print_r($questions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10 col-lg-10">
                <div class="border">
                    <div class="question bg-white p-3 border-bottom">
                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                            <h4>MCQ Quiz</h4></div>
                    </div>
                    <form action="" method="POST">
                    <div class="question bg-white p-3 border-bottom">
                        <div class="d-flex flex-row align-items-center question-title">
                            <h3 class="text-danger">Q.</h3>
                            <h5 class="mt-1 ml-2"><?php echo($questions[$id]['question']);?></h5>

                        </div><div class="ans ml-2">
                        <?php foreach ($questions[$id]['options'] as $option): ?>

                    <label class="radio"> <input type="radio" name='answer' value="<?php echo $option[0]; ?>"> <span><?php echo($option);?></span>
                    </label>    
                    </div><div class="ans ml-2">
                    <?php endforeach; ?>
</div></div>        <input type="hidden" name="score" value="<?= $score ?>">
                    <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white ">
                        <?php if($id > 0):?>
                        <a href = "index.php?id=<?=$id-1?>"class="btn btn-primary d-flex align-items-center btn-danger" type="button">
                            <i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;previous
                        </a>
                        <?php endif;?>
                        <?php if($id < sizeof($questions)-1):?>
                            <button type = "submit"> 
                                <a href = "index.php?id=<?=$id+1?>" class="btn btn-primary border-success align-items-center btn-success" type="button">
                                    Next<i class="fa fa-angle-right ml-2"></i>
                                </a>

                            </button>
                        <?php endif;?>
                        <?php if($id == sizeof($questions)-1):?>
                            <button type="submit">
                                <a href = "index.php?id=<?=$id?>" class="btn btn-primary border-success align-items-center btn-success" type="button">
                                    Cham diem<i class="fa fa-angle-right ml-2"></i>
                                </a>

                            </button>
                        <?php endif;?>
                    </div>
                </div>
                        </form>
            </div>
        </div>
    </div>
</body>
</html> -->


<?php
$file_path = 'data.txt';
$questions = [];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$score = isset($_POST['score']) ? (int)$_POST['score'] : 0;

// Kiểm tra file có tồn tại không
if (file_exists($file_path)) {
    // Đọc nội dung file
    $content = file_get_contents($file_path);
    $lines = explode("\n", $content);

    // Parse dữ liệu từ file thành các câu hỏi và đáp án
    $question = null;
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        if (strpos($line, 'ANSWER:') === 0) {
            $question['answer'] = trim(substr($line, 7));
            $questions[] = $question;
            $question = null;
        } elseif (ctype_upper($line[0]) && $line[1] === '.') {
            $question['options'][] = $line;
        } else {
            $question = ['question' => $line, 'options' => []];
        }
    }
}

// Xử lý khi người dùng gửi câu trả lời
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['answer'] ?? '';
    $correctAnswer = $questions[$id]['answer'] ?? '';

    if ($selected === $correctAnswer) {
        $score++;
    }

    // Tự động chuyển sang câu hỏi tiếp theo
    $id++;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .question-title h3 {
            color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center row">
        <div class="col-md-10 col-lg-8">
            <div class="border">
                <div class="question bg-white p-3 border-bottom">
                    <div class="d-flex flex-row justify-content-between align-items-center mcq">
                        <h4>Quizz câu hỏi</h4>
                    </div>
                </div>

                <?php if ($id < count($questions)): ?>
                    <form method="POST" action="index.php?id=<?= $id ?>">
                        <div class="question bg-white p-3 border-bottom">
                            <div class="d-flex flex-row align-items-center question-title">
                                <h3 class="text-danger">Q.</h3>
                                <h5 class="mt-1 ml-2"><?= $questions[$id]['question'] ?></h5>
                            </div>
                            <?php foreach ($questions[$id]['options'] as $option): ?>
                                <div class="ans ml-2">
                                    <label class="radio">
                                        <input type="radio" name="answer" value="<?= $option[0] ?>" required>
                                        <span><?= $option ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="score" value="<?= $score ?>">
                        <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white">
                            <?php if ($id > 0): ?>
                                <a href="index.php?id=<?= $id - 1 ?>" class="btn btn-danger">Previous</a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-success">Next</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="result bg-white p-3 text-center">
                        <h3>Quiz Completed!</h3>
                        <p>Your score is <strong><?= $score ?></strong> out of <strong><?= count($questions) ?></strong>.</p>
                        <a href="index.php?id=0" class="btn btn-primary">Restart Quiz</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
