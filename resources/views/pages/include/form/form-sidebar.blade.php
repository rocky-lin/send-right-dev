<h4 data-ng-click="InitForm()" style="cursor: pointer" >All Forms 

<span ng-show="showFormInitLoader" data-ng-init="showFormInitLoader=false" >
    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
</span>

<span class="badge pull-right" >@{{totalForm}}</span> </h4> 
<ul class="list-group form-side-bar" id="form-side-bar">
    <li class="list-group-item">
         <i class="material-icons pull-right " style="padding:0px;"   data-toggle="modal" data-target="#addFormLabel">note_add</i> 
        Label
    </li> 
    @foreach($labels as $label) 
        <li class="list-group-item" data-ng-click="loadAllByLabel({{$label->id}})" > 
            <icon class="pull-right" style="display:none;" >
                <i class="material-icons pull-right"  style="padding:0px;"  data-toggle="modal" data-target="#deleteFormLabel" ng-click="label_id={{$label->id}}" >delete_forever</i>
            </icon> 
            <count class="pull-right badge"> {{$label->labelDetails->count()}}</count> 
            {{$label->name}}  

            <span data-ng-show="showFormLabelLoader[{{$label->id}}]" data-ng-init="showFormLabelLoader[{{$label->id}}]=false" >
                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            </span>
        </li>
    @endforeach 
</ul>