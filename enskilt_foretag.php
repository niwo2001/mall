<?php 
    $page_title = "Sök enskilt företag";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class="left" style="background-color:#bbb;">
        <h2>Sök enskilt företag</h2>
        <input type="text" id="searchField" onkeyup="findSearch()" placeholder="Sök.." title="Skriv in ett företag">
        
        <ul id="searchList">

        <?php
            include("database/db_connection.php");
            $conn = OpenCon();
            $sql = "SELECT * FROM foretag"; // GET DATA 
            $result = $conn->query($sql);
            CloseCon($conn);

            while($rows=$result->fetch_assoc()) { ?>
                <li><a href="?id=<?php echo $rows['ID'];?>" ><?php echo $rows['NAMN']; ?></a></li>
            <?php } ?>
        
        </ul>
        
    </div>


    <div class="right">
        <?php
            if(empty($_GET['id'])){
                echo "<h2 id='companyNameTitle'>Page Content</h2>";
            }
            else{
                $conn = OpenCon();
                $id = $_GET['id'];
                $sql = "SELECT * FROM betalningstiduppgift WHERE BETALNINGSTID_ID = $id";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    echo $row['FAKTISK_BETALTID'];
                    echo " ";
                }
            }
        ?>
        

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
        document.getElementById("companyNameTitle").innerHTML = "Display info";
    }




  </script>


</div>

<?php 
    include("includes/footer.php");
?>