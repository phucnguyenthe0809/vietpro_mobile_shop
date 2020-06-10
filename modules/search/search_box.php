<?php
if( isset( $_GET[ 'keyword' ] ) )
{
    $keyword=$_GET[ 'keyword' ];
}
else
{
    $keyword='';
}
?>
<div  id="search" class="col-lg-6 col-md-6 col-sm-12">
    <form  class="form-inline" method="GET">
        <input name="keyword" class="form-control mt-3" type="search" placeholder="Tìm kiếm" aria-label="Search" value="<?php echo $keyword; ?>">
        <input type="hidden" value="search" name="page_layout">
        <button class="btn btn-danger mt-3" type="submit">Tìm kiếm</button>
    </form>
</div>
