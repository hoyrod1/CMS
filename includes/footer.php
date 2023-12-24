<?php
/**
 * * @file
 * php version 8.2
 * Footer for CMS
 * 
 * @category CMS
 * @package  Footer
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/footer.php
 */
?>

<!-- FOOTER BEGIN -->
<div style="height: 10px;background-color: #f4f4f4;"></div>
    <footer class="bg-secondary text-white" id="load">
        <div class="container">
            <div class="row">
               <div class="col">
                   <p class="lead text-center">
                       &copy; www.RodneyStCloud.com All Rights Reserved &nbsp | &nbsp
                      <span id="demo_1" style="color: white;">
                          <?php echo $date_time;?>
                      </span>
                  </p>
               </div>
            </div>
         </div>
    </footer>
<div style="height: 10px;background-color: #f4f4f4;"></div>
<!-- FOOTER ENDS -->
</body>
<!-- BODY AREA ENDS-->
<!--
<script>
var d_1 = new Date();
var d = d_1.toDateString();
document.getElementById("demo_2").innerHTML = d;
/*
document.getElementById("load").onload = function () {my_time_fuction(); my_date_fuction();};
function my_time_fuction()
{
var d_1 = new Date();
var n = d_1.getMinutes();
document.getElementById("demo_1").innerHTML = n;
}
function my_date_fuction()
{
var d_1 = new Date();
var d = d_1.toDateString();
document.getElementById("demo_2").innerHTML = d;
}
*/
</script>
-->

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>