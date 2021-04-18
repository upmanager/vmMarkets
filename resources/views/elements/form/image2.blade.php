@inject('lang', 'App\Lang')

<div class="col-md-4 foodm">
    <div align="right">
        <label><h4>{{$lang->get(70)}} </h4></label>
        <br>
        <button type="button" onclick="fromLibrary3()" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(77)}}</h5></button>
    </div>
</div>
<div class="col-md-8 foodm">
    <div id="dropzone3" class="fallback dropzone">
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


@inject('util', 'App\Util')

<style>
    .swal-wide{
        position: fixed !important;
        width:70% !important;
        {{--        height:400px !important;--}}
left: 30% !important;
    {{--        top: 50% !important;--}}

}
</style>

<script>

    var editFileNameNotify3;

    Dropzone.autoDiscover = false;

    var myDropzone3 = new Dropzone("div#dropzone3", {
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
                imageid3 = 0;
            var fileRef;
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: async function (file, response) {
            if (this.files.length > 1){
                this.removeFile(this.files[0]);
            }
            imageid3 = response.id;
            console.log("success " + imageid3);
        },
        error: function(file, response)
        {
            return showNotification("bg-red", response, "bottom", "center", "", "");
            return false;
        }
    });


    function fromLibrary3() {
        lastEdit3 = "";
        lastJEdit3 = "";
        selectId3 = "";
        selectName3 = "";

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
                    loadDialog2(data.data);
                },
                error: function (e) {
                    showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    console.log(e);
                }
            }
        );
    }

    function loadDialog2(data){
        var text = `<div id="div1" style="height: 600px; position:relative;">
                        <div id="div2" style="max-height:100%; min-height: 100%; overflow:auto; border:2px solid grey;">
                            <div id="thumbimagesEdit" class="row">`;
        data.forEach(function(data, i, arr) {
            text = `${text}
                    <div class="col-md-2" style="position: relative; top: 10px; left: 20px; height: 250px; margin-bottom: 10px">
                        <div id="thumbEdit${data.filename}" onclick="klikajEdit3('thumbEdit${data.filename}',
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
                if (selectId3 != "") {
                    imageid3 = selectId3;
                    mockFile = {
                        name: "images/" + selectName3,
                        size: 0,
                        dataURL: "images/" + selectName3,
                    };
                    myDropzone3.createThumbnailFromUrl(mockFile, myDropzone3.options.thumbnailWidth, myDropzone3.options.thumbnailHeight, myDropzone3.options.thumbnailMethod, true, function (dataUrl) {
                        myDropzone3.emit("thumbnail", mockFile, dataUrl);
                    });
                    myDropzone3.emit("addedfile", mockFile);
                    myDropzone3.emit("complete", mockFile);
                    myDropzone3.files.push(mockFile);
                    if (myDropzone3.files.length > 1){
                        myDropzone3.removeFile(myDropzone3.files[0]);
                    }
                    editFileNameNotify3 = selectName3;
                }
            } else {

            }
        })
    }

    var lastEdit3 = "";
    var lastJEdit3 = "";
    var selectId3 = "";
    var selectName3 = "";

    function klikajEdit3(i, j, id, name) {
        selectName3 = name;
        if (lastEdit3 !== "")
            document.getElementById(lastEdit3).style.borderColor = "#e0e0e0";
        if (lastJEdit3 !== "")
            document.getElementById(lastJEdit3).style.visibility ='hidden';
        lastJEdit3 = j;
        lastEdit3 = i;
        document.getElementById(i).style.border = "3";
        document.getElementById(i).style.borderColor = "#00FF00";
        document.getElementById(i).style.borderStyle = "solid";
        document.getElementById(j).style.visibility ='visible';
        selectId3 = id;
    }

    var editFileName3;
    var imageid3 = 0;

    function clearDropZone3(){
        imageid3 = 0;
        if (myDropzone3.files.length == 1){
            myDropzone3.removeFile(myDropzone3.files[0]);
        }
    }

    function addEditImage3(id, fileImage) {
        console.log(fileImage);
        if (myDropzone3.files.length == 1){
            myDropzone3.removeFile(myDropzone3.files[0]);
        }
        if (id == 0 || fileImage == "noimage.png")
            return;
        editFileName3 = fileImage;
        imageid3 = id;
        mockFile = {
            name: "images/"+fileImage,
            size: 0,
            dataURL: "images/"+fileImage
        };
        myDropzone3.createThumbnailFromUrl(mockFile, myDropzone3.options.thumbnailWidth, myDropzone3.options.thumbnailHeight, myDropzone3.options.thumbnailMethod, true, function (dataUrl) {
            myDropzone3.emit("thumbnail", mockFile, dataUrl);
        });
        myDropzone3.emit("addedfile", mockFile);
        myDropzone3.emit("complete", mockFile);
        myDropzone3.files.push(mockFile);
    }

</script>
