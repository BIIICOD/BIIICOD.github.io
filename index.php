<?php
$connect = mysqli_connect('localhost', 'root', '', 'minitest');
if (!$connect) {
    die('' . mysqli_connect_error());
}
$query = "SELECT * FROM `test`;";
$result = mysqli_query($connect, $query);
$data = [];
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) {
}
$code_list = [];
foreach ($data as $elem) {
    $code_list[] = $elem["code"];
}
$get_random_code = $code_list[rand(0, count($code_list) - 1)];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест</title>
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form">
        <div>
            <h1>
                Номер счета - <?= $get_random_code ?>
            </h1>
        </div>
    
        <form action='' method='POST'>
        <label for="type">Выберите тип счета</label>
            <select name='type'>
                <option>активный</option>
                <option>пассивный</option>
                <option>активно/пассивный</option>
            </select>
            <label for="input-text">Введите название счета</label>
            <input class="input-text" type='text' name='text'>
            <input name='code' value='<?= $get_random_code ?>' hidden>
            <button type='submit'>Проверить</button>
        </form>
    
    <?php

    if (isset($_POST) && !empty($_POST)) {
        $type = $_POST['type'];
        $code = $_POST['code'];
        $text = $_POST['text'];
        $check_answer = mysqli_query($connect, "SELECT * FROM `test` WHERE `code` = '$code' AND `type` = '$type' AND `text` = '$text'");
        $right_answer = mysqli_query($connect, "SELECT * FROM `test` WHERE `code` = {$_POST['code']}");
        $right_answer = mysqli_fetch_assoc($right_answer);
        if (mysqli_num_rows($check_answer) > 0) {
            echo "<div class='answercorrect'>Ура победа <br> Ответы: <br>Тип:" . $type . " <br>Код:" . $code . " <br>Название:" . $text . "</div>";
        } else {
            echo "<div class='answerincorrect'>Не ура, поражение <br>" . "Правильный ответ: <br>" . "Код: " . $right_answer['code'] . "<br> Тип: " . $right_answer['type'] . "<br> Название: " . $right_answer['text'] . "</div>";
        }
    }
    ?>

    </div>
</body>

</html>