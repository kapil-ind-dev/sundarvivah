<form action="{{ route('family_information.update', $family->id) }}" method="POST">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Edit Family Info')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Family Member')}}</label>
            <div class="col-md-9">
                <input type="text" name="family_member" value="{{ $family ? $family->family_member : '' }}" class="form-control" placeholder="{{translate('Family Member')}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Member Name')}}</label>
            <div class="col-md-9">
                <input type="text" name="member_name" value="{{ $family ? $family->member_name : '' }}" class="form-control" placeholder="{{translate('Member Name')}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Profession Status')}}</label>
            <div class="col-md-9">
                <input type="text" name="profession_status" value="{{ $family ? $family->profession_status : '' }}" class="form-control" placeholder="{{translate('Profession Status')}}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Member Details')}}</label>
            <div class="col-md-9">
                <input type="text" name="member_details" value="{{ $family ? $family->member_details : '' }}" class="form-control" placeholder="{{translate('Member Details')}}" >
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{translate('Update Family Info')}}</button>
    </div>
</form>
