<?php 
$cat_name=$_GET['cat_name'];
$cat_id=$_GET['cat_id'];

$sql="SELECT * FROM product WHERE cat_id=$cat_id";
$query=mysqli_query($conn,$sql);
//đếm số bản ghi sau khi thực thi câu lệnh truy vấn
$num=mysqli_num_rows($query);


?>
                <!--	List Product	-->
                <div class="products">
                    <h3><?php echo $cat_name; ?> (hiện có <?php echo $num; ?> sản phẩm)</h3>
                   
                    <?php
    $i=1;
    while($row = mysqli_fetch_assoc($query)){
        if($i==1){
            ?>
               <div class="product-list card-deck">
            <?php
        }
    ?>
        <div class="product-item card text-center">
            <a href="index.php?page_layout=product&prd_id=<?php echo $row['prd_id']; ?>"><img src="admin/img/products/<?php echo $row['prd_image']; ?>"></a>
            <h4><a href="index.php?page_layout=product&prd_id=<?php echo $row['prd_id']; ?>"><?php echo $row['prd_name']; ?></a></h4>
            <p>Giá Bán: <span><?php echo $row['prd_price']; ?>đ</span></p>
        </div>
        <?php
            if($i==3){
               echo '</div>';
                $i=1;
            }else{
                $i++;
            }
         }

         if($num%3!=0)
         {
             echo '</div>';
         }
        ?>

                    
                </div>
                <!--	End List Product	-->
                
                <div id="pagination">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Trang trước</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Trang sau</a></li>
                    </ul> 
                </div>
         
