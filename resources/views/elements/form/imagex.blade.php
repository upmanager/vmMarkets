@inject('lang', 'App\Lang')

<div class="col-md-4 foodm">
    <div align="right">
        <label><h4>{{$lang->get(70)}} </h4></label>
        <br>
        <button type="button" onclick="fromLibrary{{$id}}()" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(77)}}</h5></button>
    </div>
</div>
<div class="col-md-8 q-mb10">
    <div id="dropzone{{$id}}" class="fallback dropzone">
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

    // var editFileNameNotify;

    Dropzone.autoDiscover = false;

    var myDropzone{{$id}} = new Dropzone("div#dropzone{{$id}}", {
        url: "{{url('image/upload/store')}}",
        maxFilesize: 12,
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
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 50000,
        removedfile: function(file)
        {
            console.log("removedfile " + this.files.length);
            if (this.files.length == 0)
                imageid{{$id}} = 0;
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: async function (file, response) {
            if (this.files.length > 1){
                this.removeFile(this.files[0]);
            }
            imageid{{$id}} = response.id;
            console.log("success " + imageid{{$id}});
        },
        error: function(file, response) {
            return showNotification("bg-red", response, "bottom", "center", "", "");
        }
    });


    function fromLibrary{{$id}}() {
        lastEdit{{$id}} = "";
        lastJEdit{{$id}} = "";
        selectId{{$id}} = "";
        selectName{{$id}} = "";

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
                    loadDialog{{$id}}(data.data);
                },
                error: function (e) {
                    showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    console.log(e);
                }
            }
        );
    }

    function loadDialog{{$id}}(data){
        var text = `<div id="div1" style="height: 600px; position:relative;">
                        <div id="div2" style="max-height:100%; min-height: 100%; overflow:auto; border:2px solid grey;">
                            <div id="thumbimagesEdit" class="row">`;
        data.forEach(function(data, i, arr) {
            text = `${text}
                    <div class="col-md-2" style="position: relative; top: 10px; left: 20px; height: 250px; margin-bottom: 10px">
                        <div id="thumbEdit${data.filename}" onclick="klikajEdit{{$id}}('thumbEdit${data.filename}',
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
                if (selectId{{$id}} != "") {
                    imageid{{$id}} = selectId{{$id}};
                    mockFile{{$id}} = {
                        name: "images/" + selectName{{$id}},
                        size: 0,
                        dataURL: "images/" + selectName{{$id}},
                    };
                    myDropzone{{$id}}.createThumbnailFromUrl(mockFile{{$id}}, myDropzone{{$id}}.options.thumbnailWidth, myDropzone{{$id}}.options.thumbnailHeight, myDropzone{{$id}}.options.thumbnailMethod, true, function (dataUrl) {
                        myDropzone{{$id}}.emit("thumbnail", mockFile{{$id}}, dataUrl);
                    });
                    myDropzone{{$id}}.emit("addedfile", mockFile{{$id}});
                    myDropzone{{$id}}.emit("complete", mockFile{{$id}});
                    myDropzone{{$id}}.files.push(mockFile{{$id}});
                    if (myDropzone{{$id}}.files.length > 1){
                        myDropzone{{$id}}.removeFile(myDropzone{{$id}}.files[0]);
                    }
                    // editFileNameNotify = selectName;
                }
            } else {

            }
        })
    }

    var lastEdit{{$id}} = "";
    var lastJEdit{{$id}} = "";
    var selectId{{$id}} = "";
    var selectName{{$id}} = "";

    function klikajEdit{{$id}}(i, j, id, name) {
        selectName{{$id}} = name;
        if (lastEdit{{$id}} !== "")
            document.getElementById(lastEdit{{$id}}).style.borderColor = "#e0e0e0";
        if (lastJEdit{{$id}} !== "")
            document.getElementById(lastJEdit{{$id}}).style.visibility ='hidden';
        lastJEdit{{$id}} = j;
        lastEdit{{$id}} = i;
        document.getElementById(i).style.border = "3";
        document.getElementById(i).style.borderColor = "#00FF00";
        document.getElementById(i).style.borderStyle = "solid";
        document.getElementById(j).style.visibility ='visible';
        selectId{{$id}} = id;
    }

    var editFileName{{$id}};
    var imageid{{$id}} = 0;

    function clearDropZone(){
        imageid{{$id}} = 0;
        if (myDropzone{{$id}}.files.length == 1){
            myDropzone{{$id}}.removeFile(myDropzone{{$id}}.files[0]);
        }
    }

    function addEditImage{{$id}}(id, fileImage) {
        console.log(fileImage);
        if (myDropzone{{$id}}.files.length == 1){
            myDropzone{{$id}}.removeFile(myDropzone{{$id}}.files[0]);
        }
        if (id == 0 || fileImage == "noimage.png")
            return;
        editFileName{{$id}} = fileImage;
        imageid{{$id}} = id;
        mockFile{{$id}} = {
            name: "images/"+fileImage,
            size: 0,
            dataURL: "images/"+fileImage
        };
        myDropzone{{$id}}.createThumbnailFromUrl(mockFile{{$id}}, myDropzone{{$id}}.options.thumbnailWidth, myDropzone{{$id}}.options.thumbnailHeight, myDropzone{{$id}}.options.thumbnailMethod, true, function (dataUrl) {
            myDropzone{{$id}}.emit("thumbnail", mockFile{{$id}}, dataUrl);
        });
        myDropzone{{$id}}.emit("addedfile", mockFile{{$id}});
        myDropzone{{$id}}.emit("complete", mockFile{{$id}});
        myDropzone{{$id}}.files.push(mockFile{{$id}});
    }

</script>
