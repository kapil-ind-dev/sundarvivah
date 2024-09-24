<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{translate('Hobbies & Interest')}}</h5>
</div>
<div class="card-body">
    <form action="{{ route('hobbies.update', $member->id) }}" method="POST">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="hobbies">{{translate('Hobbies')}}</label>
                @php $hobbies = $member->hobbies->hobbies ?? ""; @endphp
                  <select class="form-control aiz-selectpicker" name="hobbies" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($hobbies ==  '1') selected @endif >{{translate('Bird Watching')}}</option>
                        <option value="2" @if($hobbies ==  '2') selected @endif >{{translate('Taking care of pets')}}</option>
                        <option value="3" @if($hobbies ==  '3') selected @endif >{{translate('Playing musical instruments')}}</option>
                        <option value="4" @if($hobbies ==  '4') selected @endif >{{translate('Singing')}}</option>
                        <option value="5" @if($hobbies ==  '5') selected @endif >{{translate('Dancing')}}</option>
                        <option value="6" @if($hobbies ==  '6') selected @endif >{{translate('Acting')}}</option>
                        <option value="7" @if($hobbies ==  '7') selected @endif >{{translate('Ham radio')}}</option>
                        <option value="8" @if($hobbies ==  '8') selected @endif >{{translate('Astrology/ Palmistry/ Numerology')}}</option>
                        <option value="9" @if($hobbies ==  '9') selected @endif >{{translate('Graphology')}}</option>
                        <option value="10" @if($hobbies ==  '10') selected @endif >{{translate('Solving Crosswords, Puzzels')}}</option>
                        <option value="11" @if($hobbies ==  '11') selected @endif >{{translate('Fishing')}}</option>
                        <option value="12" @if($hobbies ==  '12') selected @endif >{{translate('Collecting Stamps')}}</option>
                        <option value="13" @if($hobbies ==  '13') selected @endif >{{translate('Collecting Coins')}}</option>
                        <option value="14" @if($hobbies ==  '14') selected @endif >{{translate('Collecting antiques')}}</option>
                        <option value="15" @if($hobbies ==  '15') selected @endif >{{translate('Art/Handicraft')}}</option>
                        <option value="16" @if($hobbies ==  '16') selected @endif >{{translate('Painting')}}</option>
                        <option value="17" @if($hobbies ==  '17') selected @endif >{{translate('Cooking')}}</option>
                        <option value="18" @if($hobbies ==  '18') selected @endif >{{translate('Photography')}}</option>
                        <option value="19" @if($hobbies ==  '19') selected @endif >{{translate('Film-making')}}</option>
                        <option value="20" @if($hobbies ==  '20') selected @endif >{{translate('Model building')}}</option>
                        <option value="21" @if($hobbies ==  '21') selected @endif >{{translate('Gardening/Landscaping')}}</option>
                        <option value="22" @if($hobbies ==  '22') selected @endif >{{translate('Art/Handicraft')}}</option>
                        @error('hobbies')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
            </div>
            <div class="col-md-6">
                <label for="interests">{{translate('Interests')}}</label>
                @php $interests = $member->hobbies->interests ?? ""; @endphp
                <select class="form-control aiz-selectpicker" name="interests" >
                    <option value="">{{translate('Select One')}}</option>
                    <option value="1" @if($interests ==  '1') selected @endif >{{translate('Writing')}}</option>
                    <option value="2" @if($interests ==  '2') selected @endif >{{translate('Reading/Book clubs')}}</option>
                    <option value="3" @if($interests ==  '3') selected @endif >{{translate('Learning new languages')}}</option>
                    <option value="4" @if($interests ==  '4') selected @endif >{{translate('Listening to music')}}</option>
                    <option value="5" @if($interests ==  '5') selected @endif >{{translate('Movies')}}</option>
                    <option value="6" @if($interests ==  '6') selected @endif >{{translate('Theatre')}}</option>
                    <option value="7" @if($interests ==  '7') selected @endif >{{translate('Watching television')}}</option>
                    <option value="8" @if($interests ==  '8') selected @endif >{{translate('Travel/Sightseeing')}}</option>
                    <option value="9" @if($interests ==  '9') selected @endif >{{translate('Sports-Outdoor')}}</option>
                    <option value="10" @if($interests ==  '10') selected @endif >{{translate('Sports-Indoor')}}</option>
                    <option value="11" @if($interests ==  '11') selected @endif >{{translate('Trekking/Adventure sports')}}</option>
                    <option value="12" @if($interests ==  '12') selected @endif >{{translate('Video/Computer games')}}</option>
                    <option value="13" @if($interests ==  '13') selected @endif >{{translate('Health & Fitness')}}</option>
                    <option value="14" @if($interests ==  '14') selected @endif >{{translate('Yoga/Meditation')}}</option>
                    <option value="15" @if($interests ==  '15') selected @endif >{{translate('Alternative healing')}}</option>
                    <option value="16" @if($interests ==  '16') selected @endif >{{translate('Volunteering/Social Service')}}</option>
                    <option value="17" @if($interests ==  '17') selected @endif >{{translate('Politics')}}</option>
                    <option value="18" @if($interests ==  '18') selected @endif >{{translate('Net Surfing')}}</option>
                    <option value="19" @if($interests ==  '19') selected @endif >{{translate('Blogging')}}</option>
                    @error('interests')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="music">{{translate('Music')}}</label>
                <label for="music">{{translate('Music')}}</label>
                  @php $music = $member->hobbies->music ?? ""; @endphp
                  <select class="form-control aiz-selectpicker" name="music" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($music ==  '1') selected @endif >{{translate('Pop')}}</option>
                        <option value="2" @if($music ==  '2') selected @endif >{{translate('Disco')}}</option>
                        <option value="3" @if($music ==  '3') selected @endif >{{translate('House Music')}}</option>
                        <option value="4" @if($music ==  '4') selected @endif >{{translate('Techno')}}</option>
                        <option value="5" @if($music ==  '5') selected @endif >{{translate('Hip-Hop')}}</option>
                        <option value="6" @if($music ==  '6') selected @endif >{{translate('Rap')}}</option>
                        <option value="7" @if($music ==  '7') selected @endif >{{translate('Jazz')}}</option>
                        <option value="8" @if($music ==  '8') selected @endif >{{translate('Blue')}}</option>
                        <option value="9" @if($music ==  '9') selected @endif >{{translate('Raggae')}}</option>
                        <option value="10" @if($music ==  '10') selected @endif >{{translate('Heavy Metal')}}</option>
                        <option value="11" @if($music ==  '11') selected @endif >{{translate('Acid Rock')}}</option>
                        <option value="12" @if($music ==  '12') selected @endif >{{translate('Classical-Hindustani')}}</option>
                        <option value="13" @if($music ==  '13') selected @endif >{{translate('Classical-Carnatic')}}</option>
                        <option value="14" @if($music ==  '14') selected @endif >{{translate('Classical-Western')}}</option>
                        <option value="15" @if($music ==  '15') selected @endif >{{translate('Instrumental-Indian')}}</option>
                        <option value="16" @if($music ==  '16') selected @endif >{{translate('Instrumental-Western')}}</option>
                        <option value="17" @if($music ==  '17') selected @endif >{{translate('Old film songs')}}</option>
                        <option value="18" @if($music ==  '18') selected @endif >{{translate('Ghazals')}}</option>
                        <option value="19" @if($music ==  '19') selected @endif >{{translate('Indipop')}}</option>
                        <option value="20" @if($music ==  '20') selected @endif >{{translate('Qawalis')}}</option>
                        <option value="21" @if($music ==  '21') selected @endif >{{translate('Bhajans/Devotional')}}</option>
                        <option value="22" @if($music ==  '22') selected @endif >{{translate('Sufi music')}}</option>
                        @error('music')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
            </div>
            <div class="col-md-6">
                <label for="books">{{translate('Books')}}</label>
                @php $books = $member->hobbies->books ?? ""; @endphp
                  <select class="form-control aiz-selectpicker" name="books" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($books ==  '1') selected @endif >{{translate('Romance')}}</option>
                        <option value="2" @if($books ==  '2') selected @endif >{{translate('Thriller/Suspence')}}</option>
                        <option value="3" @if($books ==  '3') selected @endif >{{translate('Humor')}}</option>
                        <option value="4" @if($books ==  '4') selected @endif >{{translate('Science Fiction')}}</option>
                        <option value="5" @if($books ==  '5') selected @endif >{{translate('Fantasy')}}</option>
                        <option value="6" @if($books ==  '6') selected @endif >{{translate('Business/Occupational')}}</option>
                        <option value="7" @if($books ==  '7') selected @endif >{{translate('Philosophy/Spritual')}}</option>
                        <option value="8" @if($books ==  '8') selected @endif >{{translate('Self-help')}}</option>
                        <option value="9" @if($books ==  '9') selected @endif >{{translate('Short stories')}}</option>
                        <option value="10" @if($books ==  '10') selected @endif >{{translate('Comics')}}</option>
                        <option value="11" @if($books ==  '11') selected @endif >{{translate('Magazines & Newspapers')}}</option>
                        <option value="12" @if($books ==  '12') selected @endif >{{translate('Classic literature')}}</option>
                        <option value="13" @if($books ==  '13') selected @endif >{{translate('Biographies')}}</option>
                        <option value="14" @if($books ==  '14') selected @endif >{{translate('History')}}</option>
                        <option value="15" @if($books ==  '15') selected @endif >{{translate('Poetry')}}</option>
                        @error('books')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="movies">{{translate('Movies')}}</label>
                <input type="text" name="movies" value="{{ $member->hobbies->movies ?? "" }}" class="form-control" placeholder="{{translate('Movies')}}">
            </div>
            <div class="col-md-6">
                <label for="tv_shows">{{translate('TV Shows')}}</label>
                <input type="text" name="tv_shows" value="{{  $member->hobbies->tv_shows ?? "" }}" placeholder="{{ translate('TV Shows') }}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="sports">{{translate('Favourite Sports')}}</label>
                    @php $sports = $member->hobbies->sports ?? ""; @endphp
                  <select class="form-control aiz-selectpicker" name="sports" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($sports ==  '1') selected @endif >{{translate('Jogging / Walking')}}</option>
                        <option value="2" @if($sports ==  '2') selected @endif >{{translate('Cycling')}}</option>
                        <option value="3" @if($sports ==  '3') selected @endif >{{translate('Swimming / Water Sports')}}</option>
                        <option value="4" @if($sports ==  '4') selected @endif >{{translate('Cricket')}}</option>
                        <option value="5" @if($sports ==  '5') selected @endif >{{translate('Yoga / Meditation')}}</option>
                        <option value="6" @if($sports ==  '6') selected @endif >{{translate('Martial Arts')}}</option>
                        <option value="7" @if($sports ==  '7') selected @endif >{{translate('Hockey')}}</option>
                        <option value="8" @if($sports ==  '8') selected @endif >{{translate('Football')}}</option>
                        <option value="9" @if($sports ==  '9') selected @endif >{{translate('Volleyball')}}</option>
                        <option value="10" @if($sports ==  '10') selected @endif >{{translate('Bowling')}}</option>
                        <option value="11" @if($sports ==  '11') selected @endif >{{translate('Chess')}}</option>
                        <option value="12" @if($sports ==  '12') selected @endif >{{translate('Carrom')}}</option>
                        <option value="13" @if($sports ==  '13') selected @endif >{{translate('Scrabble')}}</option>
                        <option value="14" @if($sports ==  '14') selected @endif >{{translate('Card Games')}}</option>
                        <option value="15" @if($sports ==  '15') selected @endif >{{translate('Billiards/Snooker/Pool')}}</option>
                        <option value="16" @if($sports ==  '16') selected @endif >{{translate('Aerobics')}}</option>
                        <option value="17" @if($sports ==  '17') selected @endif >{{translate('Weight Training')}}</option>
                        <option value="18" @if($sports ==  '18') selected @endif >{{translate('Golf')}}</option>
                        <option value="19" @if($sports ==  '19') selected @endif >{{translate('Basketball')}}</option>
                        <option value="20" @if($sports ==  '20') selected @endif >{{translate('Tennis')}}</option>
                        <option value="21" @if($sports ==  '21') selected @endif >{{translate('Squash')}}</option>
                        <option value="22" @if($sports ==  '22') selected @endif >{{translate('Table- Tennis')}}</option>
                        <option value="23" @if($sports ==  '23') selected @endif >{{translate('Badminton')}}</option>
                        <option value="24" @if($sports ==  '24') selected @endif >{{translate('Baseball')}}</option>
                        <option value="25" @if($sports ==  '25') selected @endif >{{translate('Rugby')}}</option>
                        <option value="26" @if($sports ==  '26') selected @endif >{{translate('Adventure Sports')}}</option>
                        @error('cuisines')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>            </div>
            <div class="col-md-6">
                <label for="fitness_activities">{{translate('Fitness Activitiess')}}</label>
                <input type="text" name="fitness_activities" value="{{ $member->hobbies->fitness_activities ?? "" }}" placeholder="{{ translate('Fitness Activities') }}" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="cuisines">{{translate('Cuisines')}}</label>
                @php $cuisines = $member->hobbies->cuisines ?? ""; @endphp
                  <select class="form-control aiz-selectpicker" name="cuisines" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($cuisines ==  '1') selected @endif >{{translate('South Indian')}}</option>
                        <option value="2" @if($cuisines ==  '2') selected @endif >{{translate('Punjabi')}}</option>
                        <option value="3" @if($cuisines ==  '3') selected @endif >{{translate('Gujrati')}}</option>
                        <option value="4" @if($cuisines ==  '4') selected @endif >{{translate('Rajasthani')}}</option>
                        <option value="5" @if($cuisines ==  '5') selected @endif >{{translate('Bengali')}}</option>
                        <option value="6" @if($cuisines ==  '6') selected @endif >{{translate('Konkan')}}</option>
                        <option value="7" @if($cuisines ==  '7') selected @endif >{{translate('Chinse')}}</option>
                        <option value="8" @if($cuisines ==  '8') selected @endif >{{translate('Continental')}}</option>
                        <option value="9" @if($cuisines ==  '9') selected @endif >{{translate('Moghlai')}}</option>
                        <option value="10" @if($cuisines ==  '10') selected @endif >{{translate('Italian')}}</option>
                        <option value="11" @if($cuisines ==  '11') selected @endif >{{translate('Arabic')}}</option>
                        <option value="12" @if($cuisines ==  '12') selected @endif >{{translate('Thai')}}</option>
                        <option value="13" @if($cuisines ==  '13') selected @endif >{{translate('Sushi')}}</option>
                        <option value="14" @if($cuisines ==  '14') selected @endif >{{translate('Mexican')}}</option>
                        <option value="15" @if($cuisines ==  '15') selected @endif >{{translate('Lebanese')}}</option>
                        <option value="16" @if($cuisines ==  '16') selected @endif >{{translate('Latin American')}}</option>
                        <option value="17" @if($cuisines ==  '17') selected @endif >{{translate('Spanish')}}</option>
                        <option value="18" @if($cuisines ==  '18') selected @endif >{{translate('Fast Food')}}</option>
                        @error('cuisines')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>            </div>
            <div class="col-md-6">
                <label for="dress_styles">{{translate('Dress Styles')}}</label>
                    @php $dress_styles = $member->hobbies->dress_styles ?? ""; @endphp
                  <select class="form-control aiz-selectpicker" name="dress_styles" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($dress_styles ==  '1') selected @endif >{{translate('Classical Indian - Typical Indian formal Wear')}}</option>
                        <option value="2" @if($dress_styles ==  '2') selected @endif >{{translate('Trendy - in Line With the latest Fashion')}}</option>
                        <option value="3" @if($dress_styles ==  '3') selected @endif >{{translate('Classic Western - Typical Western Formal Wear')}}</option>
                        <option value="4" @if($dress_styles ==  '4') selected @endif >{{translate('Designer - Only Leading Brands Will do')}}</option>
                        <option value="5" @if($dress_styles ==  '5') selected @endif >{{translate('Casual - Usually in Jeans & T-shirts')}}</option>
                        @error('dress_styles')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>            
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
        </div>
    </form>
</div>
