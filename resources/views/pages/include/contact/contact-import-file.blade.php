



{{-- Source: http://plugins.krajee.com/file-avatar-upload-demo#avatar-upload-2 --}}
{{-- <link rel="stylesheet" type="text/css" href="http://plugins.krajee.com/assets/prod/all-krajee.css"> --}}
<link rel="stylesheet" type="text/css" href="http://plugins.krajee.com/assets/bf80da68/css/fileinput.min.css"> 
<script type="text/javascript" src="http://plugins.krajee.com/assets/prod/all-krajee.js"></script>
<script type="text/javascript" src="http://plugins.krajee.com/assets/bf80da68/js/fileinput.min.js"></script> 
<style>
.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 220px;
}
</style> 
{{-- {{ asset('storage/file.txt') }} --}}
<?php 
// Storage::disk('local')->put('file.txt', 'Contents');
?>
<!-- the avatar markup -->
<div id="kv-avatar-errors-1" class="center-block" style="width:800px;display:none"></div>
{{-- <form class="text-center" action="/avatar_upload.php" method="post" enctype="multipart/form-data"> --}}
    {!! Form::open(['url'=>route('user.contact.import.store'), 'files'=>true]) !!}
    <div class="kv-avatar center-block" style="width:200px">
        <div class="form-group">
            <center>
                <input id="avatar-1" name="importFile" type="file" class="file-loading">
            </center>
        </div>
        <div class="form-group">
            <center> 
                {!! Form::submit('importContacts', ['class'=>'btn btn-info']) !!}
            </center>
        </div>
    </div>
    {!! Form::close() !!}
    <!-- include other inputs if needed and include a form submit (save) button -->
{{-- </form> --}}
<!-- your server code `avatar_upload.php` will receive `$_FILES['avatar']` on form submission -->
  
<!-- the fileinput plugin initialization -->
<script>
// var btnCust = '<button type="button" class="btn btn-default" title="Add picture tags" ' + 
//     'onclick="alert(\'Comming soon..\')">' +
//     '<i class="glyphicon glyphicon-tag"></i>' +
//     '</button>'; 
var btnCust = '';  
$("#avatar-1").fileinput({
    overwriteInitial: true,
    maxFileSize: 1500,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Cancel or reset changes',
    elErrorContainer: '#kv-avatar-errors-1',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="<?php print url('public/img/logo/excel-logo.png') ?>" alt="Your file preview" style="width:160px">',
    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
    allowedFileExtensions: ["csv", 'xlsx']
});
</script> 