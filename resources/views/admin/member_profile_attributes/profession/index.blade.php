
@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Profession')}}</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="@if(auth()->user()->can('add_profession')) col-lg-7 @else col-lg-12 @endif">
        <form class="" id="sort_profession" action="" method="GET">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('All Profession') }}</h5>
                    </div>
                    
                    @can('delete_profession')
                        <div class="dropdown mb-2 mb-md-0">
                            <button class="btn btn-sm border dropdown-toggle" type="button" data-toggle="dropdown">
                                {{translate('Bulk Action')}}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal"> {{translate('Delete selection')}}</a>
                            </div>
                        </div>
                    @endcan

                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                @if(auth()->user()->can('delete_profession'))
                                    <th>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-all">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                @else
                                    <th data-breakpoints="lg">#</th>
                                @endif
                                <th>{{translate('Employed In')}}</th>
                                <th>{{translate('Title')}}</th>
                                <th class="text-right" width="20%">{{translate('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($professions as $key => $profession)
                                <tr>
                                    <td>
                                        @if(auth()->user()->can('delete_profession'))
                                            <div class="form-group d-inline-block">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]" value="{{$profession->id}}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        @else
                                            {{ ($key+1) + (professions->currentPage() - 1)*professions->perPage() }}
                                        @endif
                                    </td>
                                    <td>{{$profession->employed_title}}</td>
                                    <td>{{$profession->title}}</td>
                                    <td class="text-right">
                                        @can('edit_profession')
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="javascript:void(0);" onclick="education_modal('{{ route('profession.edit', encrypt($profession->id) )}}')" title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_profession')
                                            <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('profession.destroy', $profession->id)}}" title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $professions->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </form>
    </div>
    @can('add_religion')
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Add New Professions')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profession.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="empin_id">{{translate('Employed In')}}</label>
                            <select class="form-control" name="empin_id" id="empin_id" required>
                              <option selected value="" disabled>Select</option>
                                @foreach($employed_in as $employed)
                                    <option value="{{ $employed->id }}">{{ $employed->title }}</option>
                                @endforeach
                            </select>
                           @error('empin_id')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="title">{{translate('Title')}}</label>
                            <input type="text" id="title" name="title" placeholder="{{ translate('Enter Title') }}"
                                   class="form-control" required>
                           @error('title')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>
@endsection
@section('modal')
    @include('modals.create_edit_modal')
    @include('modals.delete_modal')
    @include('modals.bulk_delete_modal')
@endsection

@section('script')
    <script>
        function sort_profession(el){
            $('#sort_profession').submit();
        }

        function education_modal(url){
            $.get(url, function(data){
                $('.create_edit_modal').modal('show');
                $('.create_edit_modal_content').html(data);
            });
        }

        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;                       
                });
            }
          
        });

        function bulk_delete() {
            var data = new FormData($('#sort_profession')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('profession.bulk_delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
