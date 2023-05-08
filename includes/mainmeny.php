
<div class="topnav">
        <a id="b_hem" href="index.php">Start</a> 
        <a id="b_kategori" href="storlekskategori.php">Storlekskategori</a> 
        <a id="b_foretag" href="enskilt_foretag.php">Sök enskilt företag</a> 
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