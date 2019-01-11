{{--  <div class="lang">
    <img src="{{asset('img/flags/'.Lang::getLocale().'.png')}}" alt="Language" class="lang__flag-pic">
    <select  class="lang__select form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        @foreach(trans('app.languages') as $lang => $title )
            <option {{$lang == Lang::getLocale() ? 'selected' : ''}} value="{{ route(\Request::route()->getName(), ['lang' => $lang]) }}">{{$title}}</option>
        @endforeach
    </select>
</div>  --}}

<ul class="languages">
    @foreach(trans('app.languages') as $lang => $title )
        <li class="{{$lang == Lang::getLocale() ? 'active' : ''}}">
            {{--  <a href="{{lang_toggle_href($lang)}}">{{$title}}</a>  --}}
            <a href="{{ route(\Request::route()->getName(), ['lang' => $lang]) }}">
                <img src="{{asset('img/flags/'.Lang::getLocale().'.png')}}" alt="Language" class="lang__flag-pic">
                {{$title}}
            </a>
        </li>
    @endforeach
</ul>
