<html lang="en" dir="ltr">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <script src="js/jquery-3.5.1.min.js"></script>
        <link href="js/spectrum/spectrum.min.css" rel="stylesheet">
        <link href="style.css?v=5.3.5" rel="stylesheet">
</head>
<body class="qrcdr">
<input type="hidden" id="qrcdr-relative" value="">

<div class="container">
    <div class="row mt-3">

        <div class="col-lg-8 pt-3 mb-3">
            <div class="row">
                <form role="form" class="qrcdr-form needs-validationNO w-100" novalidate="">
                    <input type="submit" class="hide">
                    <input type="hidden" name="section" id="getsec" value="#link">

                    <div class="col-12 pb-2">
                        <div class="row">
                            <div class="col-12">
                            <div class="tab-content mt-3" id="dataTabs">
                                <div class="tab-pane active" id="link" role="tabpanel">
                                    <div class="form-group">
                                        <label for="malink">URL</label>
                                        <input type="text" name="link" id="malink" class="form-control ltr" placeholder="http://" required="required" value="">
                                    </div>
                                </div>
                            </div> <!-- tab content -->
                            </div><!-- main-col open at tabnav -->
                        </div> <!-- row -->
                    </div><!-- col-12-->
                </form>
            </div> <!-- row -->
        </div><!-- col-lg-8 -->

        <div class="col-lg-4 order-last">
            <nav class="navbar sticky-top">
                <div class="placeresult bg-light d-grid">
                    <div class="form-group text-center wrapresult">
                        <div class="resultholder">
                            <img class="img-fluid" src="images/placeholder.svg">
                            <div class="infopanel"></div>
                        </div>
                    </div>
                    <div class="preloader"><i class="fa fa-cog fa-spin"></i></div>
                    <input type="hidden" class="holdresult">
                    <button class="btn btn-lg btn-block btn-primary ellipsis generate_qrcode rounded-pill" disabled=""><i class="fa fa-check"></i> Save</button>
                    <div class="text-center mt-2 linksholder"></div>
                </div>
            </nav>
        </div><!-- col md-4-->

    </div><!-- row -->
</div>

<div class="alert_placeholder toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
    <div class="toast-header">
        <div class="mr-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"></path>
            </svg>
        </div>
        <button type="button" class="ml-2 ms-auto mb-1 btn-close close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
            </span>
        </button>
    </div>
    <div class="toast-body"></div>
</div>
<script type="text/javascript" src="js/popper.min.js"></script>
<script src="js/qrcdr.min.js?v=5.3.5"></script>
<script src="js/call.js?v=5.3.5"></script>    

</body></html>