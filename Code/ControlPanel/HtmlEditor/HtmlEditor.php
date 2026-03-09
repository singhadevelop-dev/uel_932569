<?php $_HTML_EDITOR_NAME = empty($_HTML_EDITOR_NAME) ? "txtDetail" : $_HTML_EDITOR_NAME ?>
<div id="AGHtmlEditor-<?php echo $_HTML_EDITOR_NAME ?>" class="AGHtmlEditor-container" style="margin-bottom:20px">
    <div id="AGHtmlEditorTarget" style="display:none;" class="AGHtmlEditorTarget"><?php IncludeDynamicPageHTML($_HTML_EDITOR_CONTENT_ID, false)  ?></div>
    <textarea class="AGHtmlEditorHTMLContainer" name="<?php echo $_HTML_EDITOR_NAME ?>" style="width:100%;display:none!important"><?php IncludeDynamicPageHTML($_HTML_EDITOR_CONTENT_ID)  ?></textarea>
    <script>
        function PrepareResource<?php echo $_HTML_EDITOR_NAME ?>() {
            if (!$("head").hasClass("AGHtmlEditor")) {
                var cssFilesList = [
                    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/froala_style.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/froala_editor.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/code_view.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/draggable.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/colors.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/emoticons.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/image_manager.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/image.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/line_breaker.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/table.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/char_counter.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/video.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/fullscreen.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/file.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/quick_insert.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/help.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/third_party/spell_checker.css",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/css/plugins/special_characters.css"
                ];
                var jsFilesList = [
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/froala_editor.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/align.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/char_counter.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/code_beautifier.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/code_view.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/colors.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/draggable.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/emoticons.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/entities.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/file.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/font_size.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/font_family.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/fullscreen.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/image.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/image_manager.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/line_breaker.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/inline_style.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/link.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/lists.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/paragraph_format.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/paragraph_style.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/quick_insert.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/quote.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/table.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/save.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/url.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/video.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/help.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/print.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/third_party/spell_checker.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/special_characters.min.js",
                    "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/lib/froala/js/plugins/word_paste.min.js"
                ];
                for (var i = 0; i < cssFilesList.length; i++) {
                    $("head").append($("<link/>", {
                        href: cssFilesList[i],
                        rel: "stylesheet"
                    }));
                }
                for (var i = 0; i < jsFilesList.length; i++) {
                    $("head").append($("<script/>", {
                        src: jsFilesList[i]
                    }));
                }
                $("head").addClass("AGHtmlEditor");
            }
            InitialFroala<?php echo $_HTML_EDITOR_NAME ?>();
        }

        function InitialFroala<?php echo $_HTML_EDITOR_NAME ?>() {
            var froalaImages = [];
            var froalaImagesUploaded = 0;
            var froalaUploadFileName = "";
            var froalaOption = {
                heightMin: 300,
                heightMax: "calc(100vh - 250px)",
                //toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'underline', 'fontSize', 'color', '|', 'align', 'outdent', 'indent', '|', 'quote', 'insertTable', 'insertImage', 'insertLink', 'insertHR', 'clearFormatting', '|', 'html', 'fullscreen', 'help'],
                toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'inlineClass', 'clearFormatting', '|', 'emoticons', 'fontAwesome', 'specialCharacters', '-', 'paragraphFormat', 'lineHeight', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '|', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '-', 'insertHR', 'selectAll', 'print', 'help', 'html', 'fullscreen', '|', 'undo', 'redo'],


                // Set the image upload URL.
                imageUploadURL: '<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/upload_image/',
                // Additional upload params.
                imageUploadParams: {
                    id: 'my_editor'
                },
                // Set request type.
                imageUploadMethod: 'POST',
                // Set max image size to 5MB.
                imageMaxSize: 10 * 1024 * 1024,
                // Allow to upload PNG and JPG.
                imageAllowedTypes: ['jpeg', 'jpg', 'png', 'webp','gif'],
                //imageDefaultWidth: 1000,


                // Set the file upload URL.
                fileUploadURL: '<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/upload_file/',
                // Additional upload params.
                fileUploadParams: {
                    id: 'my_editor'
                },
                // Set request type.
                fileUploadMethod: 'POST',
                // Set max file size to 20MB.
                fileMaxSize: 20 * 1024 * 1024,
                // Allow to upload any file.
                fileAllowedTypes: ['*'],

                // Set the video upload URL.
                videoUploadURL: '<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/upload_video/',
                // Additional upload params.
                videoUploadParams: {
                    id: 'my_editor'
                },
                // Set request type.
                videoUploadMethod: 'POST',
                // Set max video size to 20MB.
                videoMaxSize: 20 * 1024 * 1024,
                // Allow to upload any video.
                videoAllowedTypes: ["mp4", "webm", "ogg" ]
            };

            var elt = $("#AGHtmlEditor-<?php echo $_HTML_EDITOR_NAME ?> .AGHtmlEditorTarget");
            elt.froalaEditor(froalaOption).on('froalaEditor.contentChanged', function(e, editor) {
                $("#AGHtmlEditor-<?php echo $_HTML_EDITOR_NAME ?> .AGHtmlEditorHTMLContainer").val(editor.html.get());
            }).on('froalaEditor.image.removed', function(e, editor, $img) {
                $.ajax({
                        // Request method.
                        method: "POST",
                        // Request URL.
                        url: "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/upload_image/",
                        // Request params.
                        data: {
                            src: $img.attr('src')
                        }
                    })
                    .done(function(data) {
                        console.log('image was deleted');
                    })
                    .fail(function() {
                        console.log('image delete problem');
                    })
            }).on('froalaEditor.file.unlink' , function(e, editor, file) {
                $.ajax({
                    // Request method.
                    method: 'POST',

                    // Request URL.
                    url: '<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/upload_file/',

                    // Request params.
                    data: {
                        src: file.getAttribute('href')
                    }
                })
                .done(function() {
                    console.log('File was deleted');
                })
                .fail(function(err) {
                    console.log(err);
                    console.log('File delete problem: ' + JSON.stringify(err));
                })
            }).on('froalaEditor.video.removed', function(e, editor, $img) {
                $.ajax({
                        // Request method.
                        method: "POST",
                        // Request URL.
                        url: "<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/HtmlEditor/upload_video/",
                        // Request params.
                        data: {
                            src: $img.attr('src')
                        }
                    })
                    .done(function(data) {
                        console.log('image was deleted');
                    })
                    .fail(function() {
                        console.log('image delete problem');
                    })
            });

            elt.find(".fr-wrapper").css("position", "relative").append($("<div/>", {
                css: {
                    position: "absolute",
                    zIndex: 10000,
                    left: 0,
                    right: 0,
                    top: 0,
                    height: 33,
                    background: "#f7f7f7",
                    padding: "5px 15px",
                    color: "#555",
                    fontSize: 14
                },
                html: "<i class='fa fa-info-circle'></i> คุณสามารถเขียนเรื่องราว รายละเอียด พร้อมตกแต่งหรือแทรกการออกแบบของคุณได้ไม่จำกัดลงบนกล่องด้านล่างนี้"
            }));
            elt.show();
        }
        PrepareResource<?php echo $_HTML_EDITOR_NAME ?>();
    </script>
</div>