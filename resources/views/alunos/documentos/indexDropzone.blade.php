@extends('layouts.app')

@section('style')
    <style type="text/css">
        .dropzone {
            border:2px dashed #999999;
            border-radius: 10px;
        }
        .dropzone .dz-default.dz-message {
            height: 171px;
            background-size: 132px 132px;
            margin-top: -101.5px;
            background-position-x:center;

        }
        .dropzone .dz-default.dz-message span {
            display: block;
            margin-top: 145px;
            font-size: 20px;
            text-align: center;
        }
    </style>
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('alunoDoctoPend.index')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{ route('aluno.documentos.store') }}" enctype="multipart/form-data"
                    class="dropzone" id="image-upload">
                    @csrf
                    <div class="fallback">
                        <input name="fileToUpload" type="file" multiple />
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Attach dropzone on element
            Dropzone.options.imageUpload = {
                paramName: "file",
                dictDefaultMessage: "Arraste seus arquivos para cá ou clique aqui!",
                maxFiles: 2,
                maxFilesize: 2,
                acceptedFiles: ".pdf",
                addRemoveLinks: true,
                timeout: 5000,
                renameFile: function(file) {
                    var dt = new Date();
                    return dt.getTime();
                },

                success: function(file, response)
                {
                    console.log(response, file);
                },
                error: function(file, response)
                {
                return false;
                },

                removedfile: function(file)
                {
                    let url = '{{ route("aluno.documentos.destroy", ":id") }}';
                    url = url.replace(':id', file.upload.filename);
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        success: function (data){
                            console.log("File has been successfully removed!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    let fileRef;
                    return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
            };
            Dropzone.options.myAwesomeDropzone = {
                paramName: "file",
                dictDefaultMessage: "Arraste seus arquivos para cá ou clique aqui!",
                maxFiles: 2,
                maxFilesize: 2,
                acceptedFiles: ".pdf",
                addRemoveLinks: true,
                timeout: 5000,
                init: function() {
                    this.on("addedfile", function(file) { alert("Added file."); });
                }
            };
    </script>
@endsection
