<form action="{{ route('profession.update', $profession->id) }}" method="POST">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Edit Profession Info')}}</h5>

        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    
    <div class="modal-body">
      
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Employed In')}}</label>
        <div class="col-md-9">
            <select class="form-control" name="empin_id" id="empin_id" required>
              <option selected value="" disabled>Select</option>
                @foreach($employed_in as $employed)
                    <option value="{{ $employed->id }}" <?php if($profession->empin_id == $employed->id){ echo 'selected'; }?>>{{ $employed->title }}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Title')}}</label>
            <div class="col-md-9">
                <input type="text" name="title" value="{{$profession->title}}" class="form-control" placeholder="{{translate('Enter Title')}}" required>
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
    </div>
</form>
