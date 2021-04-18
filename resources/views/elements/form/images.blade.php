@inject('lang', 'App\Lang')

<div class="col-md-4 foodm">
    <div align="right">
        <label><h4>{{$lang->get(70)}} </h4></label>
        <br>
        <button type="button" onclick="fromLibrary()" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(77)}}</h5></button>
    </div>
</div>
<div class="col-md-8 q-mb10">
    <div id="dropzone2" class="fallback dropzone">
        <div class="dz-message">
            <div class="drag-icon-cph">
                <i class="material-icons">touch_app</i>
            </div>
            <h3>{{$lang->get(78)}}</h3>
        </div>
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </div>
</div>

<script>

    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("div#dropzone2", {
        url: "{{url('image/upload/store')}}",
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        sending: function(file, xhr, formData) {
            formData.append("_token", $('meta[name="_token"]').attr('content'));
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 50000,
        removedfile: function(file)
        {
            console.log(file);
            for (var i = imageArray.length; i--;){
                if (file.upload != null) {
                    if (imageArray[i].filename === file.upload.filename)
                        imageArray.splice(i, 1);
                }else{
                    if (imageArray[i].filename === file.name)
                        imageArray.splice(i, 1);
                }
            }
            console.log(imageArray);
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: async function (file, response) {
            imageArray.push({
                filename: file.upload.filename,
                id: response.id,
                new: true
            })
            console.log(imageArray);
        },
        error: function(file, response) {
            return showNotification("bg-red", response, "bottom", "center", "", "");
        }
    });

    let imageArray = [];

    function fromLibrary() {
        lastEdit = "";
        lastJEdit = "";
        selectId = "";
        selectName = "";

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("getImagesList") }}',
                data: {},
                success: function (data) {
                    console.log("getImagesList");
                    console.log(data);
                    if (data.error != "0")
                        return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    loadDialog(data.data);
                },
                error: function (e) {
                    showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    console.log(e);
                }
            }
        );
    }
    function loadDialog(data){
        var text = `<div id="div1" style="height: 600px; position:relative;">
                        <div id="div2" style="max-height:100%; min-height: 100%; overflow:auto; border:2px solid grey;">
                            <div id="thumbimagesEdit" class="row">`;
        data.forEach(function(data, i, arr) {
            text = `${text}
                    <div class="col-md-2" style="position: relative; top: 10px; left: 20px; height: 250px; margin-bottom: 10px">
                        <div id="thumbEdit${data.filename}" onclick="klikajEdit('thumbEdit${data.filename}',
                                    'iconokEdit${data.filename}', ${data.id}, '${data.filename}')"  class="thumbnail" style="height: 250px">
                                <img id="iconokEdit${data.filename}"  src="img/iconok.png" style='visibility:hidden; width: 40px; position: absolute; z-index: 100; top: 100px; left: 50px' >
                                <img src="images/${data.filename}" class="img-thumbnail" style='height: 150px; max-height: 150px; min-height: 150px; object-fit: contain; z-index: 10; ' >

                               <div style="font-size: 13px; overflow: hidden; font-weight: bold;">${data.title}</div>
                               <p>${data.updated_at}</p>
                           </div>
                       </div>
            `;
        });
        text = `${text}</div></div></div>`;

        swal({
            title: "",
            text: text,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            customClass: 'swal-wide',
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        }, function (isConfirm) {
            if (isConfirm) {
                if (selectId != "") {
                    // = selectId;
                    var mockFile = {
                        name: "images/" + selectName,
                        size: 0,
                        dataURL: "images/" + selectName,
                    };
                    myDropzone.createThumbnailFromUrl(mockFile, myDropzone.options.thumbnailWidth, myDropzone.options.thumbnailHeight, myDropzone.options.thumbnailMethod, true, function (dataUrl) {
                        myDropzone.emit("thumbnail", mockFile, dataUrl);
                    });
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("complete", mockFile);
                    myDropzone.files.push(mockFile);
                    imageArray.push({
                        filename: mockFile.name,
                        id: selectId,
                        new: false
                    })
                    console.log(imageArray);
                }
            } else {

            }
        })
    }

    var lastEdit = "";
    var lastJEdit = "";
    var selectId = "";
    var selectName = "";

    function klikajEdit(i, j, id, name) {
        selectName = name;
        if (lastEdit !== "")
            document.getElementById(lastEdit).style.borderColor = "#e0e0e0";
        if (lastJEdit !== "")
            document.getElementById(lastJEdit).style.visibility ='hidden';
        lastJEdit = j;
        lastEdit = i;
        document.getElementById(i).style.border = "3";
        document.getElementById(i).style.borderColor = "#00FF00";
        document.getElementById(i).style.borderStyle = "solid";
        document.getElementById(j).style.visibility ='visible';
        selectId = id;
    }

    function clearDropZone(){
        myDropzone.removeAllFiles(true);
        imageArray = [];
    }

    function addEditImages(images_files){
        images_files.forEach(function(item, i, arr) {
            addEditImage(item.id, item.filename, item.size);
        });
    }

    function addEditImage(id, fileImage, size) {
        if (id == 0 || fileImage == "noimage.png")
            return;
        var mockFile = {
            name: "images/"+fileImage,
            size: size,
            dataURL: "images/"+fileImage
        };
        myDropzone.createThumbnailFromUrl(mockFile, myDropzone.options.thumbnailWidth, myDropzone.options.thumbnailHeight, myDropzone.options.thumbnailMethod, true, function (dataUrl) {
            myDropzone.emit("thumbnail", mockFile, dataUrl);
        });
        myDropzone.emit("addedfile", mockFile);
        myDropzone.emit("complete", mockFile);
        myDropzone.files.push(mockFile);
        console.log(myDropzone);
        imageArray.push({
            filename: mockFile.name,
            id: id,
            new: false
        })
        console.log(imageArray);
    }

</script>
