@extends('admin.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Member Details')}}</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <span class="avatar avatar-xl m-3 center">
                    @if(uploaded_asset($member->photo) != null)
                        <img src="{{ uploaded_asset($member->photo) }}"  alt="{{translate('photo')}}">
                    @elseif(!empty($member->photo))
                        <img src="{{ static_asset('').'/'.$member->photo }}"   alt="{{translate('photo')}}">
                    @else
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}"  alt="{{translate('photo')}}">
                    @endif
                </span>
                <p>{{ $member->first_name.' '.$member->last_name }}</p>
                <div class="pad-ver btn-groups">
    				<a href="javascript:void(0);" onclick="package_info({{$member->id}})" class="btn btn-info btn-sm add-tooltip">{{ translate('Package') }}</i></a>
                    @if($member->blocked == 0)
                        <a href="javascript:void(0);" onclick="block_member({{$member->id}})" class="btn btn-dark btn-sm add-tooltip">{{ translate('Block') }}</i></a>
                    @elseif($member->blocked == 1)
                        <a href="javascript:void(0);" onclick="unblock_member({{$member->id}})" class="btn btn-dark btn-sm add-tooltip">{{ translate('Unblock') }}</i></a>
                    @endif
                    <br><br>
                    @if($member->deactivated == 0)
                        <span class="badge badge-inline badge-success">{{translate('Active Account')}}</span>
                    @else
                        <span class="badge badge-inline badge-danger">{{translate('Deactivated Account')}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 h6">{{translate('Shortlist')}}</h5><span class="text-right btn  btn-light">Export</span>
            </div>
            <div class="card-body">
              <table class="table table-responsive table-sm table-hover">
                <thead>
                    <tr>
                        <th>{{ translate('Profile') }}</th>
                        <th>{{ translate('Member Code') }}</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Phone') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortlists as $short)
                    <tr>
                        <td>
                            @if(uploaded_asset($short->photo) != null)
                                <img class="img-md" src="{{ uploaded_asset($short->photo) }}" height="45px"  alt="{{translate('photo')}}">
                            @elseif(!empty($short->photo))
                                <img class="img-md" src="{{ static_asset('').'/'.$short->photo }}" height="45px"  alt="{{translate('photo')}}">
                            @else
                                <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"  alt="{{translate('photo')}}">
                            @endif
                        </td>
                        <td>{{ $short->code }}</td>
                        <td>{{ $short->first_name.' '.$short->last_name }}</td>
                        <td>{{ str_replace('+91','',$short->phone) }}</td>
                    </tr>
                    <tr>
                        <td colspan="1"></td> <!-- empty profile cell -->
                        <td>{{ $short->code }}</td>
                        <td>{{ $short->first_name.' '.$short->last_name }}</td>
                        <td>{{ str_replace('+91','',$short->whatsapp_number) }}</td>
                    </tr>
                    <tr>
                        <td colspan="1"></td> <!-- empty profile cell -->
                        <td>{{ $short->code }}</td>
                        <td>{{ $short->first_name.' '.$short->last_name }}</td>
                        <td>{{ str_replace('+91','',$short->other_number) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <ul class="nav nav-tabs" id="myTab" role="tablist">

            <li class="nav-item ">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="shortlist-tab" data-toggle="tab" href="#shortlist" role="tab" aria-controls="home" aria-selected="true">Shortlist</a>
            </li>
            <!-- <li class="nav-item ">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ignore List</a>
            </li> -->
        </ul>
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade  show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                @include('admin.members.view-profile')
            </div>
            <div class="tab-pane fade" id="shortlist" role="tabpanel" aria-labelledby="shortlist-tab">
               @include('admin.members.view-shortlist')
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    {{-- Member Block Modal --}}
    <div class="modal fade member-block-modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form class="form-horizontal member-block" action="{{ route('members.block') }}" method="POST">
                    @csrf
                    <input type="hidden" name="member_id" id="member_id" value="">
                    <input type="hidden" name="block_status" id="block_status" value="">
                    <div class="modal-header">
                        <h5 class="modal-title h6">{{translate('Member Block !')}}</h5>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{translate('Blocking Reason')}}</label>
                            <div class="col-md-9">
                                <textarea type="text" name="blocking_reason" class="form-control" placeholder="{{translate('Blocking Reason')}}" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                        <button type="submit" class="btn btn-success">{{translate('Submit')}}</button>
                    </div>
                </form>
        	</div>
    	</div>
    </div>

    {{-- Member Unblock Modal --}}
    <div class="modal fade member-unblock-modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form class="form-horizontal member-block" action="{{ route('members.block') }}" method="POST">
                    @csrf
                    <input type="hidden" name="member_id" id="unblock_member_id" value="">
                    <input type="hidden" name="block_status" id="unblock_block_status" value="">
                    <div class="modal-header">
                        <h5 class="modal-title h6">{{translate('Member Unblock !')}}</h5>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <b>{{translate('Blocked Reason')}} : </b>
                            <span id="block_reason">{{ $member->blocked_reason }}</span>
                        </p>
                        <p class="mt-1">{{translate('Are you want to unblock this member?')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                        <button type="submit" class="btn btn-success">{{translate('Unblock')}}</button>
                    </div>
                </form>
        	</div>
    	</div>
    </div>

    @include('modals.create_edit_modal')
@endsection

@section('script')
<script type="text/javascript">
    function package_info(id){
         $.post('{{ route('members.package_info') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
             $('.create_edit_modal_content').html(data);
             $('.create_edit_modal').modal('show');
         });
     }

     function get_package(id){
         $.post('{{ route('members.get_package') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
             $('.create_edit_modal_content').html(data);
             $('.create_edit_modal').modal('show');
         });
     }

     function block_member(id){
         $('.member-block-modal').modal('show');
         $('#member_id').val(id);
         $('#block_status').val(1);
     }

     function unblock_member(id){
         $('#unblock_member_id').val(id);
         $('#unblock_block_status').val(0);
         $.post('{{ route('members.blocking_reason') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
             $('.member-unblock-modal').modal('show');
             $('#block_reason').html(data);
         });
     }

</script>
@endsection
