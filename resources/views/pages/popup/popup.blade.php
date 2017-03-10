<div class="modal fade" id="popUpModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subscription</h4>
            </div>
            <div class="modal-body">
                <p>Only Available with enterprise.</p><br>
                <button class="btn btn-info">Upgrade Now</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- new popup for add form label--}}
<div class="modal fade" id="addFormLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Form Label</h4>
            </div>
            <div class="modal-body">
                <label class="label label-default">Add New Label</label><br>
                <input type="text" class="form-control" > <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{-- end popup for add form label--}}



{{-- new popup for delete label --}}
<div class="modal fade" id="deleteFormLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Label</h4>
            </div>
            <div class="modal-body">
                <label class="label label-default">Are you sure you want to delete this label?</label><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
{{-- end popup for delete label --}}

{{-- new camapign popup create --}}
<div class="modal fade" id="createNewCampaign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Campaign</h4>
            </div>
            <div class="modal-body"> 
                <div class="row"> 
                    <div class="col-md-4">  
                    
                        {{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}}
                            <input type="hidden" value="newsletter" name="ck">
                            <button type="submit" class="btn btn-primary"> 
                                 Create Newsletter 
                            </button>
                        {{Form::close()}} 
                    </div>
                    <div class="col-md-4">  
                          {{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}}
                                <input type="hidden" value="mobile email optin" name="ck">
                                 <button type="submit" class="btn btn-primary"> 
                                        Create email optin
                                </button>
                            {{Form::close()}}
                    </div>
                    <div class="col-md-4">  
                        {{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}}
                            <input type="hidden" value="auto responder" name="ck">
                             <button type="submit" class="btn btn-primary"> 
                                Create auto responder
                            </button>
                        {{Form::close()}}
                    </div> 
                </div> 
  
                   {{-- @if($userRole == 'supper administrator') --}}
                        <hr> 
                        <a  href="{{ url('extension/campaign/index.php?type=template') }}">Create template</a> 
                    {{-- @endif --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary hide">Save changes</button>
            </div>
        </div>
    </div>
</div> 
{{-- new camapign popup create --}}