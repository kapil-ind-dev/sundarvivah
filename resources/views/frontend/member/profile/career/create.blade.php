<form action="{{ route('career.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Add New Career Info')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="user_id" value="{{ $member_id }}">
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Designation')}}</label>
            <div class="col-md-9">
                <input type="text" name="designation" class="form-control" placeholder="{{translate('designation')}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Company')}}</label>
            <div class="col-md-9">
                <input type="text" name="company"  placeholder="{{ translate('company') }}" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Job Location')}}</label>
            <div class="col-md-9">
                <input type="text" name="job_location" class="form-control" placeholder="{{translate('Job Location')}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Income')}}</label>
            <div class="col-md-9">
                <input type="text" name="income"  placeholder="{{ translate('Income') }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{translate('Add New Career Info')}}</button>
    </div>
</form>
