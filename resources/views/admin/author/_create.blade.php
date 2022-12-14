<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('author.store')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" style="padding: 0; margin: 0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create Author</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group input-group-md">
                            <span class="input-group-addon" id="sizing-addon1" style="align-self: center;margin-right: 10px;">Name</span>
                            <input type="text" name="name" value=""
                                   class="form-control" placeholder="Input Name Author"
                                   aria-describedby="sizing-addon1" required="true"
                            >
                        </div>
                    </div>

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
