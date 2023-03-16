<?php 
    $page_title = "Sök enskilt företag";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class="left" style="background-color:#bbb;">
        <h2>Sök enskilt företag</h2>
        <input type="text" id="searchField" onkeyup="findSearch()" placeholder="Sök.." title="Skriv in ett företag">
        <ul id="searchList">
            <li><a href="#" onclick="clickedCompany();">HTML</a></li>
            <li><a href="#">CSS</a></li>
            <li><a href="#">JavaScript</a></li>
            <li><a href="#">PHP</a></li>
            <li><a href="#">Python</a></li>
            <li><a href="#">jQuery</a></li>
            <li><a href="#">SQL</a></li>
            <li><a href="#">Bootstrap</a></li>
            <li><a href="#">Node.js</a></li>
            <li><a href="#">CSS</a></li>
            <li><a href="#">JavaScript</a></li>
            <li><a href="#">PHP</a></li>
            <li><a href="#">Python</a></li>
            <li><a href="#">jQuery</a></li>
            <li><a href="#">SQL</a></li>
            <li><a href="#">Bootstrap</a></li>
            <li><a href="#">Node.js</a></li>
        </ul>
    </div>

    <div class="right">
    <h2 id="companyNameTitle">Page Content</h2>
  </div>

  <script>
    function findSearch() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("searchField");
        filter = input.value.toUpperCase();
        ul = document.getElementById("searchList");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            } else {
            li[i].style.display = "none";
            }
        }
    }

    function clickedCompany() {
        document.getElementById("companyNameTitle").innerHTML = "HTML";
    }

  </script>


</div>

<?php 
    include("includes/footer.php");
?>