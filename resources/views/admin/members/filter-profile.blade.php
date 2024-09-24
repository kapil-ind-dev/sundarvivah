@extends('admin.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Filter Profile')}}</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        @include('admin.members.filter-form')
    </div>

    <div class="col-lg-8">
        @if($users)
            @include('admin.members.filtered-data')
        @endif
    </div>
</div>
@endsection
@section('script')
  <script>
    $(document).ready(function() {
            get_castes_by_religion();
            get_sub_castes_by_caste();
            get_states_by_country();
            get_cities_by_state()
            <?php if(!is_null($employedin_id)){ ?> 
            getProfession({{ $employedin_id }});
            <?php } ?>
        });

        // Get Castes and Subcastes
        function get_castes_by_religion() {
            var religion_id = $('#religion_id').val();
            $.post('{{ route('castes.get_caste_by_religion') }}', {
                _token: '{{ csrf_token() }}',
                religion_id: religion_id
            }, function(data) {
                $('#caste_id').html(null);
                $('#caste_id').append($('<option>', {
                    value: '',
                    text: 'Choose One'
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#caste_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#caste_id > option").each(function() {
                    if (this.value == '{{ $caste_id }}') {
                        $("#caste_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');

                get_sub_castes_by_caste();
            });
        }

        function get_sub_castes_by_caste() {
            var caste_id = $('#caste_id').val();
            $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}', {
                _token: '{{ csrf_token() }}',
                caste_id: caste_id
            }, function(data) {
                $('#sub_caste_id').html(null);
                $('#sub_caste_id').append($('<option>', {
                    value: '',
                    text: 'Choose One'
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#sub_caste_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#sub_caste_id > option").each(function() {
                    if (this.value == '{{ $sub_caste_id }}') {
                        $("#sub_caste_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }

        $('#religion_id').on('change', function() {
            get_castes_by_religion();
        });

        $('#caste_id').on('change', function() {
            get_sub_castes_by_caste();
        });

                   // Get Countries and States
        function get_states_by_country() {
            var country_id = $('#country_id').val();
            $.post('{{ route('states.get_state_by_country') }}', {
                _token: '{{ csrf_token() }}',
                country_id: country_id
            }, function(data) {
                $('#state_id').html(null);
                $('#state_id').append($('<option>', {
                    value: '',
                    text: 'Choose One'
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#state_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#state_id > option").each(function() {
                    if (this.value == '{{ $state_id }}') {
                        $("#state_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');

                get_cities_by_state();
            });
        }

        function get_cities_by_state() {
            var state_id = $('#state_id').val();
            $.post('{{ route('cities.get_cities_by_state') }}', {
                _token: '{{ csrf_token() }}',
                state_id: state_id
            }, function(data) {
                $('#city_id').html(null);
                $('#city_id').append($('<option>', {
                    value: '',
                    text: 'Choose One'
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#city_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#city_id > option").each(function() {
                    if (this.value == '{{ $city_id }}') {
                        $("#city_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }

        $('#country_id').on('change', function() {
            // alert('hello');
            get_states_by_country();
        });

        $('#state_id').on('change', function() {
            get_cities_by_state();
        });
        function getProfession(employedin_id){
            $.post('{{ route('get-profession') }}', {
                _token: '{{ csrf_token() }}',
                employedin_id: employedin_id
            }, function(data) {
                $('#profession_id').html(null);
                $('#profession_id').append($('<option>', {
                    value: '',
                    text: 'Choose One'
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#profession_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].title
                    }));
                }
                $("#profession_id > option").each(function() {
                    if (this.value == '{{ $profession_id }}') {
                        $("#profession_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');

            });
        }
        // get profile data
        <?php if(isset($_REQUEST['member_id'])){ ?>
            var member_id = '{{ $_REQUEST['member_id'] }}';
                getMemberProfile(member_id);
        <?php } ?>
       function getMemberProfile(member_id) {
        $.post('{{ route('get-member-profile') }}', {
            _token: '{{ csrf_token() }}',
            member_id: member_id
        }, function(data) {
            // Build the HTML structure dynamically
            let memberInfoHtml = `
            <fieldset style="margin-left: 20px;">
                <legend>Member Information</legend>
                <table class="table small-table">
                    <tr>
                        <th>Full Name:</th>
                        <td class="text-muted">${data.first_name} ${data.last_name}</td>
                    </tr>
                    <tr>
                        <th>Age + Gender:</th>
                        <td class="text-muted">${data.age} / ${data.gender == 1 ? 'Male' : 'Female'}</td>
                    </tr>
                    <tr>
                        <th>Marital Status:</th>
                        <td class="text-muted">${data.marital_status}</td>
                    </tr>
                    
                    <tr>
                        <th>Area:</th>
                        <td class="text-muted">${data.city_name ? data.city_name : 'Not Specified'}, ${data.states_name ? data.states_name : 'Not Specified'}, ${data.country_name ? data.country_name : 'Not Specified'}</td>
                    </tr>
                    <tr>
                        <th>Education:</th>
                        <td class="text-muted">${data.highest_education ? data.highest_education : 'Not Specified'}</td>
                    </tr>
                    <tr>
                        <th>Employed In + Profession:</th>
                        <td class="text-muted">${data.employedin ? data.employedin : 'Not Specified'} + ${data.profession ? data.profession : 'Not Specified'}</td>
                    </tr>
                    <tr>
                        <th>Income:</th>
                        <td class="text-muted">${data.income ? data.income : 'Not Specified'}</td>
                    </tr>
                    <tr>
                        <th>General Requirement:</th>
                        <td class="text-muted">${data.general_requirement ? data.general_requirement : 'Not Specified'}</td>
                    </tr>
                    <tr>
                        <th>DOB:</th>
                        <td class="text-muted">${formatDate(data.dob)}</td>
                    </tr>
                    <tr>
                        <th>Preferred Location:</th>
                        <td class="text-muted">${data.prefer_city_name ? data.prefer_city_name : 'NA'}</td>
                    </tr>
                </table>
            </fieldset>
            `;
            
            // Append the dynamically created content to #member_info
            $('#member_info').html(memberInfoHtml);
            
            // Refresh Bootstrap select
            AIZ.plugins.bootstrapSelect('refresh');
        });
    }
    
    // Helper function to format the date
    function formatDate(dob) {
        let dateObj = new Date(dob);
        let month = dateObj.toLocaleString('default', { month: 'long' });
        let day = dateObj.getDate();
        let year = dateObj.getFullYear();
        return `${day}th ${month} ${year}`;
    }
    
     // Shortlist
        function do_shortlist(id) {
                var shortlisted_by = '';
            <?php if(isset($_REQUEST['member_id'])){ ?>
                var shortlisted_by = '{{ $_REQUEST['member_id'] }}';
            <?php } ?>
            // alert(shortlisted_by);
            if(shortlisted_by != ''){
            $("#shortlist_a_id_" + id).removeAttr("onclick");
            $("#shortlist_id_" + id).html("{{ translate('Shortlisting') }}..");
            $.post('{{ route('add-to-shortlist') }}', {
                    _token: '{{ csrf_token() }}',
                    user_id: id,
                    shortlisted_by: shortlisted_by,
                },
                function(data) {
                    if (data == 1) {
                        $("#shortlist_id_" + id).html("{{ translate('Shortlisted') }}");
                        $("#shortlist_id_" + id).attr("class", "d-block fs-10 opacity-60 text-primary");
                        $("#shortlist_a_id_" + id).attr("onclick", "remove_shortlist(" + id + ")");
                        AIZ.plugins.notify('success', '{{ translate('You Have Shortlisted This Member.') }}');
                    } else {
                        $("#shortlist_id_" + id).html("{{ translate('Shortlist') }}");
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            );
            }else{
                alert('please select a member first!');
            }
        }

        function remove_shortlist(id) {
             var shortlisted_by = '';
            <?php if(isset($_REQUEST['member_id'])){ ?>
                var shortlisted_by = '{{ $_REQUEST['member_id'] }}';
            <?php } ?>
            // alert(shortlisted_by);
            if(shortlisted_by != ''){
            $("#shortlist_a_id_" + id).removeAttr("onclick");
            $("#shortlist_id_" + id).html("{{ translate('Removing') }}..");
            $.post('{{ route('remove-from-shortlist') }}', {
                    _token: '{{ csrf_token() }}',
                    user_id: id,
                    shortlisted_by: shortlisted_by,
                },
                function(data) {
                    if (data == 1) {
                        $("#shortlist_id_" + id).html("{{ translate('Shortlist') }}");
                        $("#shortlist_id_" + id).attr("class", "d-block fs-10 opacity-60 text-dark");
                        $("#shortlist_a_id_" + id).attr("onclick", "do_shortlist(" + id + ")");
                        AIZ.plugins.notify('success',
                            '{{ translate('You Have Removed This Member From Your Shortlist.') }}');
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            );
            }else{
                alert('please select a member first!');
            }
        }

        </script>
@endsection

