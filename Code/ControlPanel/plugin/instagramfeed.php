
<?php $_COG_ITEM_CODE = "INSTAGRAM_FEED" ?>
<?php include  "../header.php"; ?>

<?php 


if(isset($_POST["btnUpdate"])){
    $txtIGFeedToken = $_POST["txtIGFeedToken"];
    $sqlUpdate = "update website set IGFeedToken = '$txtIGFeedToken' ";
    ExecuteSQL($sqlUpdate);
}
$data = SelectRow("select IGFeedToken from website where 1=1 limit 1");

?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-plug fa-fw"></i>
                <span class="analysis-left-menu-desc">Instagram Feed</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="instagramfeed.php" class="link-history-btn">ปลั๊กอิน</a>
    /
    <span class="link-history-btn">Instagram Feed</span>

</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-12">
            <div>
                <span><b>อัพเดตปลั๊กอิน Instagram Feed</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-md-10">
                        <form action="" method="post">
                            <label>Instagram Feed Token</label>
                            <div class="input-group mb-3">
                                <input type="text" name="txtIGFeedToken" value="<?php echo $data["IGFeedToken"] ?>" class="form-control" placeholder="Token...">
                                <span class="input-group-addon hand" onclick="$('#btnUpdate').click();" style="color:white;background-color: #04ac9c !important;">
                                    <i class="fa fa-save"></i> บันทึก
                                </span>
                            </div>
                            <button type="submit" id="btnUpdate" name="btnUpdate" style="display: none;"><i class="fa fa-save"></i> บันทึก</button>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <div style="padding-top: 2.5rem;">
                            <button type="button" class="btn btn-info" onclick="$('#modal-IGfeed-token').modal('show')"><i class="fa fa-file-o"></i> วิธีการหาสร้าง Token</button>
                        </div>
                    </div>
                </div>
                <?php if(!empty($data["IGFeedToken"])){ ?>
                <span><b>ตัวอย่างแสดง Instagram Feed</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-md-12">
                        <style type="text/css">
                            #instafeed-container a img{ 
                                margin: 1rem;
                                width: 22%;
                                object-fit: cover;
                                transform: translate3d(0,0,0);
                                position: relative;
                                overflow: hidden;
                                border-radius: 0.3rem;
                            }
                        </style>
                        <div id="instafeed-container"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="modal-IGfeed-token" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog text-left modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <p class="" title="">
                        <i class="fa fa-file-o fa-fw"></i>
                        วิธีการหาสร้าง Token
                    </p>
                </h4>
            </div>
            <div class="modal-body">
                <div class="inner-video overlay-dark mb-6">
                    <iframe width="100%" height="500" src="https://www.youtube.com/embed/X2ndbJAnQKM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php if(!empty($data["IGFeedToken"])){ ?>
<script src="https://cdn.jsdelivr.net/gh/stevenschobert/instafeed.js@2.0.0rc1/src/instafeed.min.js"></script>
<script type="text/javascript">
	var userFeed = new Instafeed({
		get: 'user',
		target: "instafeed-container",
		resolution: 'low_resolution',
		limit: 8,
		accessToken: '<?php echo $data["IGFeedToken"] ?>'
	});
	userFeed.run();
</script>
<?php } ?>
<?php include  "../footer.php"; ?>