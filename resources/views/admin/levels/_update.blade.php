<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('levels.update')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" style="padding: 0; margin: 0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Package</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input id="name" type="text" name="name" value=""
                                   class="form-control p-name" placeholder="Input Name Category"
                                   aria-describedby="sizing-addon1" required="true"
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exp" class="col-sm-2 col-form-label">EXP</label>
                        <div class="col-sm-10">
                            <input id="exp" type="number" name="exp" value=""
                                   class="form-control p-exp" placeholder="Input EXP Category"
                                   aria-describedby="sizing-addon1" required="true"
                            >
                        </div>
                    </div>

                    <input type="hidden" name="level_id" class="p-id">
                    @csrf()
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
