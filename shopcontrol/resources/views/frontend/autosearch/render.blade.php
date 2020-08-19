
{{--Your SEARCH--}}
@forelse($search_sugstns as $sugstn)
    <li class="">
        <a class="search-keyword" href="{{url('search?string='. $sugstn->search_text)}}">{{$sugstn->search_text}}</a>
        <a href="javascript:void(0)" class="removeBtn" data-rowId="{{$sugstn->id}}">Remove</a>
    </li>
@empty
@endforelse




{{--POPULAR SEARCH--}}
@forelse($sugstns as $sugstn)
    <li class="">
        <a class="search-keyword" href="{{url('search?string='. $sugstn->search_text)}}">{{$sugstn->search_text}}</a>
    </li>
@empty
@endforelse