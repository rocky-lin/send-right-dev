
<h4 data-ng-click="campaignDisplayByKind('all')" style="cursor: pointer" >All Campaigns

<span ng-show="showCampaignInitLoader" data-ng-init="showCampaignInitLoader=false" >
    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
</span>

 <span class="badge pull-right" >@{{totalCampaign}}</span> </h4>


<h4>Draft <span class="badge pull-right ">0</span></h4>
<hr> 
<ul class="list-group form-side-bar" id="form-side-bar">
    <li class="list-group-item">
         <i class="material-icons pull-right " style="padding:0px;"   data-toggle="modal" data-target="#addCampaignLabel">note_add</i> 
        Label
    </li> 
    @foreach($labels as $label)
        <li class="list-group-item" data-ng-click="loadAllByLabel({{$label->id}})" >
            <icon class="pull-right" style="display:none;  " ><i class="material-icons pull-right"  style="padding:0px;"  data-toggle="modal" data-target="#deleteFormLabel"  data-ng-click="label_id={{$label->id}}">delete_forever</i></icon> 
            <count class="pull-right badge"> {{$label->labelDetails->count()}}</count>
            {{$label->name}}

            <span data-ng-show="showCampaignLabelLoader[{{$label->id}}]" data-ng-init="showCampaignLabelLoader[{{$label->id}}]=false" >
                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            </span>
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