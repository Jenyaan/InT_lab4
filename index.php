<?php
$historyFile = 'history.txt';

function logHistory($num1, $num2, $operation, $result) {
    global $historyFile;
    $date = date('Y-m-d H:i:s');
    $entry = "[$date] $num1 $operation $num2 = $result\n";
    file_put_contents('history.txt', $entry, FILE_APPEND); 
}
$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["num1"]) && isset($_POST["num2"]) && isset($_POST["operation"])) {

        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $operation = $_POST["operation"];

        switch ($operation) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                $result = $num2 != 0 ? ($num1 / $num2) : "Не можна!";
                break;
        }

        if ($result !== "") {
            logHistory($num1, $num2, $operation, $result);
        }
    }

}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор з історією</title>
</head>
<body>

    <div>
        <h2>Калькулятор</h2>
        <form method="post">
            <input type="number" name="num1" placeholder="Перше число" required>
            <select name="operation" required>
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
            </select>
            <input type="number" name="num2" placeholder="Друге число" required>
            <button type="submit">=</button>
        </form>

        <div>
            <?php
            if ($result !== "") {
                echo "Результат: " . $result;
            }
            ?>
        </div>
    </div>

    <div>
        <h3>Історія обчислень:</h3>
        <?php
        if (file_exists($historyFile)) {
            $history = file_get_contents($historyFile);
            echo nl2br($history);
        } else {
            echo "Історія порожня.";
        }
        ?>
    </div>

</body>
</html>
