<?php 
$_X_MAP_LOCATION = empty($_DEFAULT_MAP_LOCATION) ? "13.752801,100.501587" : $_DEFAULT_MAP_LOCATION;
$_X_MAP_LOCATION_ARR = explode(",",$_X_MAP_LOCATION);
$_X_MAP_LOCATION_LAT = $_X_MAP_LOCATION_ARR[0];
$_X_MAP_LOCATION_LNG = $_X_MAP_LOCATION_ARR[1];
?>
<style>
.divMap {
    position: relative;
}
.map-top-command {
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 2;
}
    .map-top-command .form-control {
        display: inline-block;
    }
.googleMap {
    z-index: 1;
}
</style>
<div id="modal-google-map-" class="modal fade">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="divMap">
                    <div class="map-top-command">
                        <div class="input-group pull-right" style="width: 400px;margin-left:5px;">
                            <input type="text" class="form-control input-sm" id="txtSearchText" onkeypress="searchtextKeyPress(event);" placeholder="ค้นหาสถานที่"  />
                            <span class="input-group-addon hand" onclick="searchMapFromKeyword();">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control input-sm" id="txtLat" value="<?php echo $_X_MAP_LOCATION_LAT ?>" disabled style="width: 150px" />
                        <input type="text" class="form-control input-sm" id="txtLng" value="<?php echo $_X_MAP_LOCATION_LNG ?>" disabled style="width: 150px" />
                    </div>
                    <div id="googleMap" class="googleMap" style="width: 100%; height: 475px;"></div>
                    <script>
                        var map = null;
                        var gmarkers = [];
                        var objTrigger;
                        //setTimeout คือ หน่วงเวลาการโชว์แผนที่ ครึ่งวินาที ??
                        function openSuperGridGoogleMapMap(obj) {
                            objTrigger = $(obj);
                            $("#modal-google-map-").modal("show");
                            setTimeout(function () {
                                if (map == null) {
                                    initGoogleMap();
                                } else {
                                    googleMapResize();
                                }
                            }, 500);
                        }
                        //initGoogleMap() คือการ map=null ให้สร้าง map ใหม่
                        //googleMapResize() กระตุ้นตัวเองโดยไม่ต้องใช้เน็ต ลดภาระในการโหลด googleMap ครั้งแรก
                        //chooseAndCloseMap() ฟังก์ชั่นสุดท้ายเมื่อกดยืนยันที่อยู่หรือ ปุ่ม Choose location
                        function chooseAndCloseMap() {
                            $("body").find(".lat-lng").val($("#txtLat").val() + "," + $("#txtLng").val());
                            $("#modal-google-map-").modal("hide"); //ปิดแผนที่ ผิดป็อบอัพไป ซ่อน=hide
                            $.ajax({
                                url: "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + $("#txtLat").val() + "," + $("#txtLng").val() + "&sensor=true&lang=th",
                                success: function (datas) { //ส่งค่าแอดติจูด ลองติจูดไป ที่urlด้านบน แล้วจะออกมาเป็นค่า string คือ address ให้อีกที
                                    var addr = datas.results[0].formatted_address;
                                    $("body").find(".address").val(addr);
                                    $(".chk-location").each(function () {
                                        try {
                                            var label = $(this).next("label").html().toLowerCase();
                                            if (addr.toLowerCase().indexOf(label) > 0)
                                                $(this).prop("checked", true);
                                        } catch (e) { }
                                    });
                                }
                            });
                        }
                        //searchtextKeyPress ช่องค้นหาที่อยู่ เป็นฟังก์ชั่นของ google  searchMapFromKeyword
                        function searchtextKeyPress(event) {
                            if (event.which === 13) {
                                searchMapFromKeyword();
                                event.stopPropagation();
                                event.preventDefault();
                                return false;
                            }
                        }
                        function initGoogleMap() {
                            var mapProp = {
                                center: new google.maps.LatLng(<?php echo $_X_MAP_LOCATION ?>),
                                zoom: 14,
                                disableDoubleClickZoom: true,
                                //disableDoubleClickZoom: ไม่ให้ใช้ DoubleClick ในการ zoom ให้กดปุ่มเว้นวรรค บนคีย์บอร์ดแทน
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
                            map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                            createMarkerFromLatLng(<?php echo $_X_MAP_LOCATION ?>);
                            // createMarkerFromLatLng ใช้สร้าง Marker ครั้งแรกสร้างที่ประเทศไทย
                            google.maps.event.addListener(map, 'dblclick', function (event) {
                                $("#txtLat").val(event.latLng.lat());
                                $("#txtLng").val(event.latLng.lng());
                                removeMarkers(); //เอา Marker ออก
                                createMarkerFromLatLng(event.latLng.lat(), event.latLng.lng()); //ชี้ Marker ที่จุดใหม่ เมื่อทำการ DoubleClick
                            });
                        }
                        //googleMapResize() ปรับขนาด map
                        function googleMapResize() {
                            google.maps.event.trigger(map, 'resize');
                            map.setZoom(map.getZoom());
                            map.setCenter(new google.maps.LatLng($("#txtLat").val(), $("#txtLng").val()));
                        }
                        //DefaultLocation การตั้งค่าเริ่มต้น
                        function googleMapDefaultLocation(address) {
                            document.getElementById('txtSearchText').value = address;
                            searchMapFromKeyword(false);
                        }
                        //การค้นหาที่อยู่ ด้วย keyหรือที่อยู่ ที่เรากรอกลงไป
                        function searchMapFromKeyword(isSetDefault) {
                            var geocoder = new google.maps.Geocoder();
                            var address = document.getElementById('txtSearchText').value;
                            geocoder.geocode({ 'address': address }, function (results, status) {
                                if (status === 'OK') {
                                    map.setCenter(results[0].geometry.location);
                                    createMarker(results[0]);
                                    $("#txtLat").val(results[0].geometry.location.lat());
                                    $("#txtLng").val(results[0].geometry.location.lng());
                                } else {
                                    // do not alert if not found 
                                    //alert('ไม่พบข้อมูลที่ค้นหา [reason: ' + status + ']');
                                }
                            });
                        }
                        // function createMarker ใช้สร้าง marker
                        function createMarker(place) {
                            var placeLoc = place.geometry.location;
                            var marker = new google.maps.Marker({
                                map: map,
                                position: place.geometry.location
                            });
                            gmarkers.push(marker);
                            google.maps.event.addListener(marker, 'click', function () {
                                infowindow.setContent(place.name);
                                infowindow.open(map, marker);
                            });
                        }
                        function createMarkerFromLatLng(lat, lng) {
                            var marker = new google.maps.Marker({
                                map: map,
                                draggable: true,
                                position: new google.maps.LatLng(lat, lng)
                            });
                            //แอด event ให้ google marker เลื่อนจุดได้
                            marker.addListener('drag', handleEvent);
                            marker.addListener('dragend', handleEvent);
                            gmarkers.push(marker);
                        }
                        function handleEvent(event) {
                            $("#txtLat").val(event.latLng.lat());
                            $("#txtLng").val(event.latLng.lng());
                        }
                        function removeMarkers() {
                            for (i = 0; i < gmarkers.length; i++) {
                                gmarkers[i].setMap(null);
                            }
                        }
                        //AIzaSyD5ES8GFHrarPhIVpDhFDea6fPtga0Wy4Y
                    </script>
                    <script src="https://maps.google.com/maps/api/js?libraries=places,geometry&key=AIzaSyAoNZHpAl4xo-8ZQReyy9qX9yxUS6iRGYs"
                        type="text/javascript"></script>
                </div>
                <div class="text-right" style="margin-top:10px;">
                    <span class="btn btn-success" onclick="chooseAndCloseMap();">
                        Choose location
                    </span>
                    <span class="btn btn-default" data-dismiss="modal">
                        Close map
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
