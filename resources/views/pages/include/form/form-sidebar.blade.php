
<h4>All Forms <span class="badge pull-right" >@{{totalCampaign}}</span> </h4>
 

<ul class="list-group form-side-bar" id="form-side-bar">
    <li class="list-group-item">
         <i class="material-icons pull-right " style="padding:0px;"   data-toggle="modal" data-target="#addFormLabel">note_add</i> 
        Label
    </li>


    @foreach($labels as $label)
        <li class="list-group-item">
            <icon class="pull-right" style="display:none;  " ><i class="material-icons pull-right"  style="padding:0px;"  data-toggle="modal" data-target="#deleteFormLabel"  >delete_forever</i></icon> 
            <count class="pull-right badge">1</count>
            {{$label->name}}
        </li>
    @endforeach
{{--     <li class="list-group-item">
        <icon class="pull-right" style="display:none; " ><i class="material-icons pull-right" style="padding:0px;" data-toggle="modal" data-target="#deleteFormLabel"  >delete_forever</i></icon>
        <count class="pull-right badge">1</count>
        Label name 2
    </li>
    <li class="list-group-item">
        <icon class="pull-right" style="display:none;  " ><i class="material-icons pull-right"  style="padding:0px;" data-toggle="modal" data-target="#deleteFormLabel"  >delete_forever</i></icon>
        <count class="pull-right badge">1</count>
        Label name 3
    </li> --}}
</ul>