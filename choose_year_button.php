<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="option">Antal år:</label>
  <select name="option" id="option">
    <option value="3">3</option>
    <option value="2">2</option>
    <option value="1">1</option>
  </select>
  <input type="submit" value="Submit">
</form>


<?php
function saveSelectedOptionToFile() {
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["option"])) {
      $selectedOption = $_POST["option"];
      // Save the selected option to a file
      $file = fopen('samples/year.txt', 'w');
      fwrite($file, $selectedOption);
      fclose($file);
    }
  }
}

// Call the function to save the selected option
saveSelectedOptionToFile();
?>

