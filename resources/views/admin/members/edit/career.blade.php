<div class="m-4">
    @php 
        $employed_in = \App\Models\EmployedInModel::get();
        $profession = \App\Models\ProfessionModel::get();
    @endphp
    <form action="{{ route('member.emplyeed_profession.update', $member->id) }}" method="POST">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="employed_in" >{{translate('Employed In')}}</label>
                 <select class="form-control" name="employed_in" id="employed_in" required onchange="getProfession(this.value)">
                  <option value="" selected disabled>Select</option>
                  @foreach($employed_in as $row)
                    <option value="{{ $row->id }}" <?php if($row->id == $member->member->employed_in){ echo 'selected';} ?>>{{ $row->title }}</option>
                  @endforeach
                </select>
                @error('employed_in')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="profession" >{{translate('Profession')}}</label>
                 <select class="form-control" name="profession" id="profession" required>
                  <option value="" selected disabled>Select</option>
                  @foreach($profession as $row)
                    <option value="{{ $row->id }}" <?php if($row->id == $member->member->profession){ echo 'selected';} ?>>{{ $row->title }}</option>
                  @endforeach
                </select>
                @error('profession')
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
    <h5 class="mb-0 h6">{{translate('Career Info')}}</h5>
    <div class="text-right">
        <a onclick="career_add_modal('{{$member->id}}');"  href="javascript:void(0);" class="btn btn-sm btn-primary ">
          <i class="las mr-1 la-plus"></i>
          {{translate('Add New')}}
        </a>
    </div>
</div>

<table class="table">
    <tr>
        <th>{{translate('designation')}}</th>
        <th>{{translate('company')}}</th>
        <th>{{translate('Start')}}</th>
        <th>{{translate('End')}}</th>
        <th>{{translate('Status')}}</th>
        <th>{{translate('option')}}</th>
    </tr>

    @php $careers = \App\Models\Career::where('user_id',$member->id)->get(); @endphp
    @foreach ($careers as $key => $career)
    <tr>
        <td>{{ $career->designation }}</td>
        <td>{{ $career->company }}</td>
        <td>{{ $career->start }}</td>
        <td>{{ $career->end }}</td>
        <td>
            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" id="status.{{ $key }}" onchange="update_career_present_status(this)" value="{{ $career->id }}" @if($career->present == 1) checked @endif data-switch="success"/>
                <span></span>
            </label>
        </td>
        <td class="text-right">
            <a href="javascript:void(0);" class="btn btn-soft-primary btn-icon btn-circle btn-sm" onclick="career_edit_modal('{{$career->id}}');" title="{{ translate('Edit') }}">
                <i class="las la-edit"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('career.destroy', $career->id)}}" title="{{ translate('Delete') }}">
                <i class="las la-trash"></i>
            </a>
        </td>
    </tr>
    @endforeach

</table>

