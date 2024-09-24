<div class="m-4">
    @php 
        $highest_education = \App\Models\HighestEducation::get();
    @endphp
    <form action="{{ route('member.heightest_education.update', $member->id) }}" method="POST">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="heighest_education" >{{translate('Highest Education')}}</label>
                <select class="form-control" name="heighest_education" id="heighest_education" required>
                  <option value="" selected disabled>Select</option>
                  @foreach($highest_education as $h_edu)
                    <option value="{{ $h_edu->id }}" <?php if($h_edu->id == $member->member->heighest_education){ echo 'selected';} ?>>{{ $h_edu->title }}</option>
                  @endforeach
                </select>
                @error('heighest_education')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="education_details" >{{translate('Education Details')}}</label>
                <input type="text" name="education_details" value="{{ $member->member->education_details ? $member->member->education_details : '' }}" class="form-control" placeholder="{{translate('Education Details')}}" >
                @error('education_details')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
        </div>
    </form>
</div>


<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{translate('Education')}}</h5>
    <div class="text-right">
        <a onclick="education_add_modal('{{$member->id}}');"  href="javascript:void(0);" class="btn btn-sm btn-primary ">
          <i class="las mr-1 la-plus"></i>
          {{translate('Add New')}}
        </a>
    </div>
</div>
<table class="table">
    <tr>
        <th>{{translate('Degree')}}</th>
        <th>{{translate('Institution')}}</th>
        <th>{{translate('Start')}}</th>
        <th>{{translate('End')}}</th>
        <th>{{translate('Status')}}</th>
        <th class="text-right">{{translate('option')}}</th>
    </tr>

    @php $educations = \App\Models\Education::where('user_id',$member->id)->get(); @endphp
    @foreach ($educations as $key => $education)
    <tr>
        <td>{{ $education->degree }}</td>
        <td>{{ $education->institution }}</td>
        <td>{{ $education->start }}</td>
        <td>{{ $education->end }}</td>
        <td>
            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" id="status.{{ $key }}" onchange="update_education_present_status(this)" value="{{ $education->id }}" @if($education->present == 1) checked @endif data-switch="success"/>
                <span></span>
            </label>
        </td>
        <td class="text-right">
            <a href="javascript:void(0);" class="btn btn-soft-primary btn-icon btn-circle btn-sm" onclick="education_edit_modal('{{$education->id}}');" title="{{ translate('Edit') }}">
                <i class="las la-edit"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('education.destroy', $education->id)}}" title="{{ translate('Delete') }}">
                <i class="las la-trash"></i>
            </a>
        </td>
    </tr>
    @endforeach

</table>
