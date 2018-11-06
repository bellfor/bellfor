<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">


    <div class="page-header">
        <div class="container-fluid">

            <?php if(!isset($sampletabledata)){ ?>
            <div class="pull-right"><a href="<?php echo $sampleexport; ?>" data-toggle="tooltip" title="<?php echo $sample_export; ?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></a> <button class="btn btn-primary" title="" data-toggle="tooltip" form="form" type="submit" name="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
            </div>
            <?php } ?>

            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="content">

        <?php if(isset($sampletabledata)) {  
                                               

			$coupon_table_data="";

			$coupon_table_data .="<div class='table-responsive'><table class='table table-bordered table-hover'><thead><tr><td class='text-center'>Coupon Name</td><td class='text-left'>Code</td><td class='text-left'>Discount</td><td class='text-left'>Date Start</td><td class='text-left'>Date End</td><td class='text-left'>Status</td></tr></thead><tbody>";

            $excel_fields_error = array();

           // $product_names = array();

            $excel_field_validate = 1;
            //print_r($sampletabledata);exit;
            foreach($sampletabledata as $coupondata)  { 

		                      

            $coupon_table_data .="<tr><td class='left'>".$coupondata['name']."</td><td class='left'>".$coupondata['code']."</td><td class='left'>".$coupondata['discount']."</td><td class='left'>".$coupondata['date_start']."</td><td class='left'>".$coupondata['date_end']."</td><td class='left'>".$coupondata['status']."</td></tr>";

            } 

            $coupon_table_data .="</tbody></table></div>";
    ?>

    <div class="buttons">
        <?php if($excel_field_validate) { ?>
       <a href="<?php echo $importdataurl; ?>" class="button" id="button-save1">Publish</a>
          <!-- <a href="javascript:void(0)" class="button" id="button-save1">Publish</a>-->
        <?php } ?>
        <a href="<?php echo $action; ?>" class="button">Go Back</a>
    </div>

    <?php if(!$excel_field_validate) { ?>
    <div>
        </br>
        <h4>Warning :
            <?php
			 if(count($excel_fields_error)>0)
            {
            foreach($excel_fields_error as $current_error)
            {
            echo "<span class='error'>".$current_error."</span><br>";
            }
            }
            ?>
        </h4>
        <h5>Kindly goback then upload valid Excel file only</h5>
    </div>
    <?php }  ?>
    <h4></h4>
    <?php echo $coupon_table_data; ?>
    <?php } else { ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="table table-bordered table-hover">
            <tr>
                <td class="text-left"><?php echo $entry_import; ?></td>
                <td class="text-left">
                    <input type='file' name='file' />
                    <?php if ($error_file) { ?>
                    <span class="error"><?php echo $error_file; ?></span>
                    <?php } ?>
                    <?php if ($error_fields) { ?>
                    <span class="error"><?php echo $error_fields; ?></span>
                    <?php } ?>
                </td>
            </tr>
            
        </table>
    </form>
    <?php } ?>
</div>
</div>
<?php echo $footer; ?>
</div>

<style type="text/css">
    .button {
        text-decoration: none;
        color: #FFF;
        display: inline-block;
        padding: 3px 5px;
        background: #003A88;
        -webkit-border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -khtml-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        cursor:pointer;
    }

    .error
    {
        color:red;
    }
</style>


