<input type="text" id="searchField" onkeyup="findSearch()" placeholder="Sök.." title="Skriv in ett företag">
        
<ul id="searchList">

    <?php
        include_once("database/db_connection.php");
        $conn = OpenCon();
        $sql = "SELECT * FROM foretag"; // GET DATA 
        $result_foretag = $conn->query($sql);
        CloseCon($conn);

        while($rows=$result_foretag->fetch_assoc()) { ?>
            <li><a href="?id=<?php echo $rows['ID'];?>" ><?php echo $rows['NAMN']; ?></a></li>
    <?php } ?>

</ul>


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
            } 
            else {
                li[i].style.display = "none";
            }
        }
    }
</script>

