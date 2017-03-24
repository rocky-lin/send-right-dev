<?php

namespace Support;

class Popup
{

    public static function campaign_delete_label()
    {
        ?>
        <div class="modal fade" id="deleteFormLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete Label</h4>
                    </div>
                    <div class="modal-body">
                        <label class="label label-default">Are you sure you want to delete this label?</label><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" data-ng-click="deleteNewLabel()">Delete</button>
                    </div>
                </div>
            </div>
        </div><?php
    }

    public static function campaign_add_label()
    { ?>
        <div class="modal fade" id="addCampaignLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Campaign Label</h4>
                    </div>
                    <div class="modal-body">
                        <label class="label label-default">Add New Label</label><br>
                        <input type="text" class="form-control" ng-model="name" required=""> <br>

                        <div ng-init="label_popup_message=false" ng-show="label_popup_message"
                             class="alert alert-danger"> Field required!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveNewLabel()">Save</button>
                    </div>
                </div>
            </div>
        </div><?php
    }

    public static function form_delete_label()
    {
        ?>
        <div class="modal fade" id="deleteFormLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete Label</h4>
                    </div>
                    <div class="modal-body">
                        <label class="label label-default">Are you sure you want to delete this label?</label><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" data-ng-click="deleteNewLabel()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public static function form_add_label()
    { ?>
        <div class="modal fade" id="addFormLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Label</h4>
                    </div>
                    <div class="modal-body">
                        <label class="label label-default">Add New Label</label><br>
                        <input type="text" class="form-control" data-ng-model="name" required=""> <br>

                        <div ng-init="label_popup_message=false" ng-show="label_popup_message"
                             class="alert alert-danger"> Field required!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveNewLabel()">Add New Label</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    public static function globalSearchPopup()
    {
        ?>

        <div class="modal fade" id="searchGlobal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Search Campaigns and Subscribers</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Anything <span class="caret">
												</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#">Anything</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Campaigns</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Subscribers</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <input class="form-control" aria-label="Text input with dropdown button"
                                                   name="searchGlobal" placeholder="Search...">
                                                       <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><i
                                                                class="material-icons">search</i></button>
                                                      </span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>


        <?php
    }

    public static function globalHelpPopup()
    {
        ?>

        <div class="modal fade" id="helpGlobal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Search the Knowledge Base</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search Article">
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="material-icons">search</i>
                                    </button>
                                  </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>


        <?php
    }

}