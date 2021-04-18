<div class="col-md-12 " style="margin-bottom: 5px">
    <div class="col-md-4 form-control-label" >
        <label for="{{$id}}"><h4>{{$label}}
                @if ($request == "true")
                    <span class="col-red">*</span>
                @endif
            </h4></label>
    </div>
    <div class="col-md-8" style="margin-bottom: 0px">
        <div id="dropzone" class="fallback dropzone">
            <div class="dz-message">
                <div class="drag-icon-cph">
                    <i class="material-icons">touch_app</i>
                </div>
                <h4>{{$label2}}</h4>
            </div>
            <div class="fallback">
                <input name="file" type="file" multiple />
            </div>
            <label id="dropzoneerror" for="{{$id}}" class="font-12 font-bold col-pink"><p></p></label>
        </div>
    </div>
</div>

<script>
    Dropzone.autoDiscover = false;
    var dropZoneFileName = "";

    var myDropzone = new Dropzone("div#dropzone", {
        url: "{{url('csvUpload')}}",
        //maxFilesize: 12, // MB
        maxFiles: 1,
        // parallelUploads: 5,
        addRemoveLinks: true,
        dictMaxFilesExceeded: "{{$error1}}",
        dictRemoveFile: "{{$deleteText}}",
        //dictCancelUploadConfirmation: "Are you sure to cancel upload?",
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        init: function () {
            this.hiddenFileInput.removeAttribute('multiple');
        },
        sending: function(file, xhr, formData) {
            formData.append("_token", $('meta[name="_token"]').attr('content'));
        },
        acceptedFiles: ".csv",
        timeout: 50000,
        removedfile: function(file)
        {
            document.getElementById("dropzoneerror").innerHTML = "";
            if (!clearDropZone) {
                console.log("remove:" + file);
                console.log("remove:" + file.upload);
                dropZoneFileName = "";
                if (file.upload != null) {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("csvDestroy") }}',
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            filename: name
                        },
                        success: function (data) {
                            console.log("File has been successfully removed!!");
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            }

            var fileRef;
            return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: async function (file, response) {
            console.log("length " + this.files.length);
            console.log("ok: " + response.filename);
            if (mockFileEditPresent) {
                mockFileEditPresent = false;
                this.removeFile(mockFileEdit);
            }
            dropZoneFileName = response.filename;
        },
        error: function(file, response)
        {
            if (this.files.length > 1) {
                this.removeFile(this.files[1]);
            }
            console.log("error" + response);
            document.getElementById("dropzoneerror").innerHTML = response;
            return false;
        }
    });

    var clearDropZone = false;
    function dropzoneClearFiles(){
        console.log(myDropzone);
        if (mockFileEditPresent) {
            myDropzone.removeFile(mockFileEdit);
            mockFileEditPresent = false;
        }
        if (myDropzone.files.length == 1){
            console.log("remove file: " + myDropzone.files[0]);
            clearDropZone = true;
            myDropzone.removeFile(myDropzone.files[0]);
            clearDropZone = false;
        }
        dropZoneFileName = "";
    }

    var mockFileEditPresent = false;
    var mockFileEdit = { name: "", size: 0 };
    var mockFileNameEdit = "";

    function dropzoneEdit(image, imagesize){
        if (mockFileEditPresent)
            myDropzone.removeFile(mockFileEdit);
        myDropzone.removeAllFiles(true);
        mockFileEdit = {
            name: "news/"+image,
            size: imagesize,
            dataURL: "news/"+image
        };
        dropZoneFileName = image;
        mockFileNameEdit = image;
        mockFileEditPresent = true;
        myDropzone.createThumbnailFromUrl(mockFileEdit, myDropzone.options.thumbnailWidth, myDropzone.options.thumbnailHeight, myDropzone.options.thumbnailMethod, true, function (dataUrl) {
            myDropzone.emit("thumbnail", mockFileEdit, dataUrl);
        });
        myDropzone.emit("addedfile", mockFileEdit);
        myDropzone.emit("complete", mockFileEdit);
    }

</script>
