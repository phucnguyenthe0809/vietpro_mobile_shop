<?php
//keyword= iphone x
$arr_key=explode(" ",$keyword); // array('iphone','x');
$key_end=implode("%",$arr_key); // iphone%x

// số item trong 1 trang
$sl_sp=6;

$sql="SELECT * FROM product WHERE prd_name LIKE '%$key_end%'";
$query=queryGetItem($sql,$sl_sp);




?>

<!--	List Product	-->
<div class="products">
    <div id="search-result">Kết quả tìm kiếm với sản phẩm <span><?php echo $keyword; ?></span></div>
    <div class="row">
        <?php while($row=mysqli_fetch_assoc($query)) {?>
        <div class="product col-lg-4 col-md-4 col-sm-6">
            <div class="product-item card text-center">
                <a href="#"><img src="admin/img/products/<?php echo $row['prd_image']; ?>"></a>
                <h4><a href="#"><?php echo $row['prd_name']; ?></a></h4>
                <p>Giá Bán: <span><?php echo number_format( $row[ 'prd_price' ], 0, '', '.' ) ?>đ</span></p>
            </div>
        </div>
        <?php } ?>


    </div>

</div>
<!--	End List Product	-->

<div id="pagination">
   <?php echo Links($sql,$sl_sp); ?>
</div>