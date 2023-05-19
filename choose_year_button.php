<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="option">Antal år:</label>
  <select name="option" id="option">
    <option value="3">3</option>
    <option value="2">2</option>
    <option value="1">1</option>
  </select>
  <input type="submit" value="Välj">
</form>


<?php
function saveSelectedOptionToFile() {
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["option"])) {
      $selectedOption = $_POST["option"];
      $file = fopen('samples/year.txt', 'w');
      fwrite($file, $selectedOption);
      fclose($file);
    }
  }
}

saveSelectedOptionToFile();
?>

