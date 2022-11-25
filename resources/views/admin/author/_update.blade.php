<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('author.update')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Package</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-md">
                            <span class="input-group-addon" id="sizing-addon1">Name</span>
                            <input type="text" name="name" value=""
                                   class="form-control p-name" placeholder="Basic"
                                   aria-describedby="sizing-addon1" required="true"
                            >
                        </div>
                    </div>

                    <input type="hidden" name="author_id" class="p-id">
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
