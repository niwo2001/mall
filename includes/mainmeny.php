
<div class="topnav">
        <a id="b_hem" href="index.php">Hem</a> 
        <a id="b_kategori" href="storlekskategori.php">Storlekskategori</a> 
        <a id="b_foretag" href="enskilt_foretag.php">Enskilt företag</a> 
        <a id="b_sammanlagd" href="sammanlagd_statistik.php">Sammanlagd statistik</a>
</div>

<script>

if (window.location.pathname === '/index.php') {
    document.getElementById("b_hem").style.backgroundColor ="rgb(0, 74, 173)"
}
else if (window.location.pathname === '/storlekskategori.php'){
    document.getElementById("b_kategori").style.backgroundColor ="rgb(0, 74, 173)"
}
else if (window.location.pathname === '/enskilt_foretag.php'){
    document.getElementById("b_foretag").style.backgroundColor ="rgb(0, 74, 173)"
}
else if (window.location.pathname === '/sammanlagd_statistik.php'){
    document.getElementById("b_sammanlagd").style.backgroundColor ="rgb(0, 74, 173)"
}

</script>

<!--

<div id="mainmenu">
    <button class="buttonClick" id="b_hem"          onclick="location.href='index.php'">Hem</button>
    <button class="buttonClick" id="b_foretag"      onclick="location.href='enskilt_foretag.php'">Sök enskilt företag</button>
    <button class="buttonClick" id="b_sammanlagd"   onclick="changeColor('b_sammanlagd'); location.href='sammanlags_statistik.php'">Sammanlagd statistik</button>
    <button class="buttonClick" id="b_kategori"     onclick="changeColor('b_kategori'); location.href='storlekskategori.php'">Storlekskategori</button>
</div>



<script>    
    
    const element1 = document.getElementById("b_hem");
    element1.addEventListener("click", function(){
        document.getElementById("b_hem").style.backgroundColor ="rgb(17, 115, 251)"
        document.getElementById("b_foretag").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_sammanlagd").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_kategori").style.backgroundColor ="rgb(0, 74, 173)"
    })

    const element2 = document.getElementById("b_foretag");
    element2.addEventListener("click", function(){
        document.getElementById("b_hem").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_foretag").style.backgroundColor ="rgb(17, 115, 251)"
        document.getElementById("b_sammanlagd").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_kategori").style.backgroundColor ="rgb(0, 74, 173)"
    })

    const element3 = document.getElementById("b_sammanlagd");
    element3.addEventListener("click", function(){
        document.getElementById("b_hem").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_foretag").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_sammanlagd").style.backgroundColor ="rgb(17, 115, 251)"
        document.getElementById("b_kategori").style.backgroundColor ="rgb(0, 74, 173)"
    })

    const element4 = document.getElementById("b_kategori");
    element4.addEventListener("click", function(){
        document.getElementById("b_hem").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_foretag").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_sammanlagd").style.backgroundColor ="rgb(0, 74, 173)"
        document.getElementById("b_kategori").style.backgroundColor ="rgb(17, 115, 251)"
    })




    function changeColor(buttonId) {
        // Get all buttons with the class "menuButton"
        var buttons = document.getElementsByClassName("buttonClick");

        // Remove the "active" class from all buttons
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
            buttons[i].classList.style.backgroundColor = "#000000"
        }

        // Add the "active" class to the clicked button
        var button = document.getElementById(buttonId);
        button.classList.add("active");

        document.getElementById(buttonId).style.backgroundColor = "rgba(255,0,0,0.8)";
    }


</script>

-->
