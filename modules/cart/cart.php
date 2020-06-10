<?php

if(isset( $_SESSION[ 'cart' ] ))
{
    //cập nhập giỏ hàng
    if(isset( $_POST['sbm'] ))
    {
        $_SESSION[ 'cart' ]=$_POST['cart'];
    }


    $cart    = $_SESSION[ 'cart' ];
    $arr_key = array_keys( $cart );
    $str_key = implode(',', $arr_key );


    $sql    = "SELECT * FROM product WHERE prd_id IN($str_key)";
    $query  = mysqli_query($conn,$sql);

?>

                <!--	Cart	-->
                <div id="my-cart">
                	<div class="row">
                        <div class="cart-nav-item col-lg-7 col-md-7 col-sm-12">Thông tin sản phẩm</div> 
                        <div class="cart-nav-item col-lg-2 col-md-2 col-sm-12">Tùy chọn</div> 
                        <div class="cart-nav-item col-lg-3 col-md-3 col-sm-12">Giá</div>    
                    </div>  
                    <form method="post">
                    <?php 
                    $total=0;
                    while($row = mysqli_fetch_assoc($query) ) {
                        $total+=$cart[ $row['prd_id'] ]*$row['prd_price'];
                        ?>

                    <div class="cart-item row">
                        <div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                        	<img src="admin/img/products/<?php echo $row['prd_image']; ?>">
                            <h4><?php echo $row['prd_name']; ?></h4>
                        </div> 
                        
                        <div class="cart-quantity col-lg-2 col-md-2 col-sm-12">
                        	<input name="cart[<?php echo $row['prd_id'] ?>]" type="text" id="quantity" class="form-control form-blue quantity" value="<?php echo $cart[ $row['prd_id'] ]; ?>" min="1">
                        </div> 
                        <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo $row['prd_price']*$cart[ $row['prd_id'] ]; ?>đ</b><a href="modules/cart/del_item_cart.php?prd_id=<?php echo $row['prd_id']; ?>">Xóa</a></div>    
                    </div>  

                    <?php } ?>

                    <div class="row">
                    	<div class="cart-thumb col-lg-7 col-md-7 col-sm-12">
                        	<button id="update-cart" class="btn btn-success" type="submit" name="sbm">Cập nhật giỏ hàng</button>	
                        </div> 
                        <div class="cart-total col-lg-2 col-md-2 col-sm-12"><b>Tổng cộng:</b></div> 
                        <div class="cart-price col-lg-3 col-md-3 col-sm-12"><b><?php echo $total; ?>đ</b></div>
                    </div>
                    </form>
                               
                </div>
                <!--	End Cart	-->
<?php } else { ?>
<div class="alert alert-danger" role="alert">
    <strong>giỏ hàng rỗng</strong>
</div>
<?php } ?>









<?php
require 'SendMail/src/Exception.php';
require 'SendMail/src/PHPMailer.php';
require 'SendMail/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


    if(isset($_POST['email']))
    {
        if($_POST['email']!='')
        {
            $name=$_POST['name'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
            $address=$_POST['address'];

            $mailHTML='
            <div style="border: 1px dotted forestgreen;">
            <h3 align="center">Thông tin khách hàng</h3>
            Họ tên:'.$name.' <br>
            Sđt:'.$phone.' <br>
            email: '.$email.' <br>
            địa chỉ : '.$address.'
        </div>
        <table style="width: 100%;" >
            <thead style="background-color: cornflowerblue;">
                <tr>
                    <th>Mã Sản phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>';
     
            $sql    = "SELECT * FROM product WHERE prd_id IN($str_key)";
            $query  = mysqli_query($conn,$sql);
          
            while ($row=mysqli_fetch_assoc($query)) {
                $mailHTML.='<tr>
                <td>#'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$_SESSION['cart'][ $row['prd_id'] ].'</td>
                <td>'.$row['prd_price'].'</td>
                <td>'.$row['prd_price']*$_SESSION['cart'][ $row['prd_id'] ].'</td>
                </tr>';
            }
          
                

       
            $mailHTML.='<tr style="font-size: 30px; font-weight: bold; color: red;">
                    <td >Tổng tiền</td>
                    <td  colspan="4" align="right">'.$total.'</td>
                </tr>
              
            </tbody>
        </table>
        <p align="center" style="font-weight: bold;">Cảm ơn bạn đã mua hàng bên vietpro</p>        
            ';

          

            //send mail
            $mail = new PHPMailer(true);

            try {
                //Server settings
                                 // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'phucnguyenthe0809@gmail.com';                     // SMTP username
                $mail->Password   = 'jwihrxlsrwbbarjg';                               // SMTP password
                $mail->SMTPSecure = 'TLS';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('phucnguyenthe0809@gmail.com', 'VIETPRO');
                $mail->addAddress($email, 'Khách hàng');     // Add a recipient
                $mail->CharSet = 'UTF-8';
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Xác nhận đơn hàng';
                $mail->Body    =  $mailHTML;

                $mail->send();
              header('location:index.php?page_layout=success');
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
      

        }
    }

?>
                <!--	Customer Info	-->
                <div id="customer">
                	<form id="frm" method="post">
                    <div class="row">
                    	
                    	<div id="customer-name" class="col-lg-4 col-md-4 col-sm-12">
                        	<input placeholder="Họ và tên (bắt buộc)" type="text" name="name" class="form-control" required>
                        </div>
                        <div id="customer-phone" class="col-lg-4 col-md-4 col-sm-12">
                        	<input placeholder="Số điện thoại (bắt buộc)" type="text" name="phone" class="form-control" required>
                        </div>
                        <div id="customer-mail" class="col-lg-4 col-md-4 col-sm-12">
                        	<input placeholder="Email (bắt buộc)" type="text" name="email" class="form-control" required>
                        </div>
                        <div id="customer-add" class="col-lg-12 col-md-12 col-sm-12">
                        	<input placeholder="Địa chỉ nhà riêng hoặc cơ quan (bắt buộc)" type="text" name="address" class="form-control" required>
                        </div>
                        
                    </div>
                    </form>
                    <div class="row">
                    	<div class="by-now col-lg-6 col-md-6 col-sm-12">
                        	<a onclick="buyNow()">
                            	<b>Mua ngay</b>
                                <span>Giao hàng tận nơi siêu tốc</span>
                            </a>
                        </div>
                        <div class="by-now col-lg-6 col-md-6 col-sm-12">
                        	<a href="#">
                            	<b>Trả góp Online</b>
                                <span>Vui lòng call (+84) 0988 550 553</span>
                            </a>
                        </div>
                    </div>
                </div>
<script>
    function buyNow()
    {
        document.getElementById('frm').submit()
    }
</script>
                <!--	End Customer Info	-->
 