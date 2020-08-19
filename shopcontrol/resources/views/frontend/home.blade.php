@extends('frontend.layouts.master')
@section('content')
    <div class="main-contents">
        <div class="container">
            <div class="home-container">
                <div class="_ecom_-logo"><img src="{{asset('public/assets/img/_ecom__logo.png')}}" alt=""></div>

                @if(@$notices)
                    <div class="row">
                        <div class="col-md-10 block-center">

                            <div class="alert alert-info" style="margin-bottom: 10px; padding-bottom: 8px">
                                <marquee behavior="scroll" direction="left" onmouseover="this.stop();"
                                         onmouseout="this.start();">

                                    @forelse($notices as $notice)
                                        @if(@$notice->notice_message)
                                            {!! @$notice->notice_message !!}
                                        @endif
                                    @empty
                                    @endforelse

                                </marquee>
                            </div>

                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-10 block-center">
                        <div class="navigation home">
                            <div class="clearfix">

                                <div class="h-middle">
                                    <form action="{{url('search')}}" class="header-search-form" method="get">
                                        <div class="input-group search-container">
                                            <input name="string" id="myInput" onkeyup="myFunction()" type="text"
                                                   class="form-control main-search-form" required
                                                   placeholder="খুজুন..." autocomplete="off">

                                            <div class="search-result-mini">

                                                <ul id="myUL" class="search-list scrollable"></ul>

                                                <ul class="search-list alt scrollable">
                                                    {{--Your SEARCH--}}
                                                    @php
                                                        $isExist = array();
                                                        $search_sugstns = \App\models\UserSpecificSearchHistory::where('user_id', Auth::id())->orderBy('total_hit', 'desc')->take(5)->get();
                                                        $sugstns = \App\models\SearchHistory::orderBy('total_hit', 'desc')->take(5)->get();
                                                    @endphp

                                                    @forelse($search_sugstns as $sugstn)
                                                        <?php
                                                        $isExist[] = $sugstn->search_text;
                                                        ?>
                                                        <li class="" id="li-{{$sugstn->id}}">
                                                            <a class="search-keyword"
                                                               href="{{url('search?string='. $sugstn->search_text)}}">{{$sugstn->search_text}}</a>
                                                            <a href="javascript:void(0)" class="removeBtn"
                                                               data-rowid="{{$sugstn->id}}">Remove</a>
                                                        </li>
                                                    @empty
                                                        <li></li>
                                                    @endforelse


                                                    {{--POPULAR SEARCH--}}

                                                    @php
                                                        $sugstns = \App\models\SearchHistory::whereNotIn('search_text', $isExist)->orderBy('total_hit', 'desc')->take(5)->get();
                                                    @endphp
                                                    @forelse($sugstns as $sugstn)
                                                        <li class="">
                                                            <a class="search-keyword"
                                                               href="{{url('search?string='. $sugstn->search_text)}}">{{$sugstn->search_text}}</a>
                                                        </li>
                                                    @empty
                                                    @endforelse


                                                </ul>

                                                <div class="read-more">
                                                    <button type="submit" class="more-btn">See all result for <strong
                                                                class="plxKeyword"></strong></button>
                                                </div>
                                            </div>

                                            <div class="input-group-btn">
                                                <button class="btn btn-default btn-primary" type="submit"><i
                                                            class="icon-magnifier"></i>&nbsp; {{ __('text.search') }}
                                                </button>
                                            </div>
                                        </div>
                                        <a class="refineSearch" href="javascript://">
                                            <span class="text-danger">&times;</span>{{ __('text.refine-search') }}
                                        </a>
                                        <div class="refine-search-list">
                                            <label for="rsAll" class="custom-checkbox">
                                                <input class="rsDefault refineItem" type="checkbox" id="rsAll"
                                                       name="ep_ids[]" value="all">
                                                <span></span>
                                                All
                                            </label>
                                            @forelse($ep_list as $each_ep)
                                                <label for="rs{{$each_ep->id}}"
                                                       class="custom-checkbox">
                                                    <input class="rsEp refineItem" type="checkbox"
                                                           id="rs{{$each_ep->id}}" name="ep_ids[]"
                                                           value="{{$each_ep->id}}">
                                                    <span></span>
                                                    {{$each_ep->ep_name}}
                                                </label>
                                            @empty
                                            @endforelse

                                            <script>
                                                $('input.refineItem').on('change', function () {
                                                    if ($(this).val() === 'all') {
                                                        if ($(this).is(':checked')) {
                                                            $('input.refineItem').not(this).prop('checked', true);
                                                        } else {
                                                            $('input.refineItem').not(this).prop('checked', false);
                                                        }
                                                    } else {
                                                        $('input.rsDefault').not(this).prop('checked', false);
                                                        if (parseInt($('.refineItem:checked').length) + parseInt(1) === $('.refineItem').length) {
                                                            $('input.refineItem').not(this).prop('checked', true);
                                                        }
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="keyword-list clearfix">

                            <div class="list-item">
                                <a href="{{url("search?string=Medicine")}}" class="item ratio-1-1" title="Medicine">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAATrSURBVFhH5Zh7iFVVGMXHx4zlaKNOOqkVpDWjqYiJNMhglkKklTLBlGYYSYlhSEqI4itLzT8kif4oNAlCo9JIfAS9IyppUDKFlIkIKlEhTSwhtZl+a7PO4cxc03PvPXf6owWLvde3v/3tdc9zn1vWWWhtbR0AR8GhbW1tPR3+74CJLpi5H26Dp9DtQOwQXAeHekrngUXHw29s5BzcRXcV7ZNwIdwID3r8PHyVbh9PLy1Y7Ckv+htczMK9PJQDxofDt6DQAkd5qDRgged8VL6Cgx2+IsidBs8w9XfaOoezBYWft7mdsIfDqcGc0fBP2EKZbE83RWNzNBUO5w3mN7rOeoeKR8Lce8WYi0CdD+A5al3nUOFImCvqyCVBrUmuOc+hwlAKcwK1ulFTT4CdDuWPUpmLQN2P4BHL/JAw92kpzAnUfgOeskwPJq22uQtQj4QJHsoU1H0HHrdMByZE5vZCvQF+hjJ5h1MyAzW/hgcsrwx8rbK59+ErcAy8GWZukmWqqKdX5SaHLo+EOR25SvghvEtjtLFJUiaGCUWCWrO1Hpju0L+D5JVO/gw2OBzA2CBYC2+BmZhkfjl1foA/0r/8DUjSCpLCkaN5gvYv2qs8rPHN8Ev3Y5PwzpBQAJi71ms+4tClQULSXAUsh0M8HIDWtTLQMjL5CyzIJHMehsIOandxOBckLCMhuubehKs9JFMV6G/hVIeUPxIehYNh0mS4TtOA3CZ4ER6ElQ7ngsFZNqcboYc0vMfDAegVMN6z0e8HtXUPhWl1XaY2SU5k7jvY3+Fc4GssCSp6gL7u3L4eUpEb4NOWAYw3EGu0DEDrB90GZfJXqHqTPJwDxtKZE0jQLvg0rIfHZdhDMjOd2E8w3ogSewH9rmUA+gu4yP3YJLmTQ0ICxPMyN5UiOrVLHQogVAXjO1cgZwCxdhcxsRp3AxjvBq8lfkmT6PTmBJK2UkAGjzoUgP4YbrHUwt3R+kp7zCHl1HturUOKLYYn3K+DsUna/MwxqSuJ2n99Dsc7HIDWK63dd6sWgfE3A+O6mXQGujqkmD7S440EfZk8BvXj0psTSKyhuI7As9bVcDeh+LmH1nfudmLdHVLscbjGMgD9Mmyy1I/phd4FR8BnvE56cwLJoz0xbLHp9qGv7c5NIQEQ0x2uyyBpcDZcbhmA3kBO/A5FV6Lfpl0J8ztyEZhQRxEZ3ADbvQHQ4+BwywD0FFhtKa1T/EAH8wPR4aag/xAszJxAId2pMvg3bHE4AP0JfM1SuXqT/EH7qEPKuR0K8bVKfxHUw3oGLNxcBCZrB7EP9pbGQHiM0PaE5R1iVWqFjrGE1h9Hc2Hx5gQK6PTqCGp/p7eGHtjjPKzxRqiHd3I38yLcYxmAboZL4EyYjTmBhYdRSN8ZW+jrNC6A13hYC18P51oGoHVq77UMQDcxX2+Y7MxFoJj2d8LdDik2B95nGWADt1oqpwZuJK5HirZM2ZsTWED7u+9p9Q9TvWK0+v5YFhIAY3qT6IMm3uHQ1weUtmCFP0rSgsK6BqMn/hwMRRe9TvuIkGSgq4nfCHXkXqLVk2A/LI25CCyg663ZC2qH8yCcD88Tim8S+q8T0zv2mHO30XTOf88sFN0oJ724cBZqI6sNhP4NbfXYYTjNUzsXLHw11B/huha1mTgCZUh/ka3HXwOMNwn/Q5SV/QM2Ow2UIjVMdQAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.medicine') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="list-item">
                                <a href="{{url("search?string=Sharee")}}" class="item ratio-1-1" title="Sharee">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkVGNUE5MTBDMTIzQTExRThBMDM5RDkyRTBDM0YxNEQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkVGNUE5MTBEMTIzQTExRThBMDM5RDkyRTBDM0YxNEQ2Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RUY1QTkxMEExMjNBMTFFOEEwMzlEOTJFMEMzRjE0RDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RUY1QTkxMEIxMjNBMTFFOEEwMzlEOTJFMEMzRjE0RDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz416O+xAAAD90lEQVR42syYy29MURzH7x0dOh2tTj2qLS0Vz3oVIV7xisSCEAsJYWchYiex8idgISIRGxuPxMIj2Eg8KiEUoY1nSj1b1UGr1bep70k+Nznbuc09epNPZm7nnM53vuf3+53fuf7g4KA3nK+cIcxdIMaIGu73ifnijngB/03gJLFU+GIU72PiCMJXi7h4NlSBsRBzKsRCcVo8FhvFDFErWsRVcV3sR7hzB0eITnFA/GYpG0W9SIikKBTtYrN45NJBs5wpBEzFrV7xU/xC3GhRLMrFH9dLPF6sQtRRxBSSGEZUrqgWO8Q5YUpEqUuBObiVJ5rEJlEguhHYzQ94Le7j+EyXAmeRmUbIdubfptyYJZ4gWkWDqBInGRt3JbBS7GRZDyOmllfj1BpRxDJX8FpEfXQi8JL4IraKm7jnkb3LxApiz4z5SkwW4rATgc3igvgrjok2/p4vXrHs78UZ4tQI/CxKwm4KYSatFecpyh4iTF0s4z5Jln+y7k22j7XmROZgLtvbNetvEygluThcSWKkRQfj2yhRTrK4k/rmkZ1GwFxKyinrsyJ2Ex/BU10INHHVj1tFuGW2vi2ijmxOMTaFiz1iYthSk61AE+xdxFMuMXxQPMCtJpIkiO88srnHlcBSljJNR7NX3BWXEVRCHJorIyaLb+I5YiujFviOgD8udokb4qGYI14iciVjB1jmDHNaw1SNbCcsYHcwrdUH2qxZfHkeS51gbJ/1PonQgagd3IW4E3zhb5ImTRlJWa1+p2VAE3FYSlmKTOAhXqvYPXycTJI8synSHs1DPu/bcG9OtsmSrcB2XBok4CtxxuwiT3G1mrEtLHvScjETtYMZ5vhWfeuFPpzyGfuX+wruG3B7D05HIrDX6qz7EfmDYj2az+usXaaPHxFcPku9MMoziWe1+mnuC0gKj466jOyO0WkncLKB2JwbZQw2Mi9jBfwATtXTnPoIecKYeYxvJH7boqqDHZxJqpgbbGfNnI1rOBIYp6fwg8r4QY9w12yF96JyMIEgcyj6ThmZzS4yEsEbKCdG2DYyvQtxFWyNzVE5GJSYWhyZiJAntFQe7rxnSfPZhz+RQGej3up8ltnjUP7RKhn99HxXyNIMLl90eezsYd+Ns9RvrLrXYRVh0yu+JSSWu3700YO4IHt/URcbrWbgK2XoFrHnTGBwQEqwhB7C4gjv5X8a0esIg/Kw7X7YhrWAxjSGoyWISPH5Igp5cJgyCbXb1eO3cWIaX9xFrSsmQZpxNs72Z7J3sXV4ciJwBFmbw27Qzn6bR2sf/IBWYm8STxpqwgr0s3yIvkSsJw7TtFQpnsuY99PZaYLCfT1MFz0Ugc6vmDfMr38CDABRKgT7/Djm7wAAAABJRU5ErkJggg=="
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.sharee') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Salwar Kameez")}}" class="item ratio-1-1"
                                   title="Salwar Kameez">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAK8SURBVFhH7ZhLSFVRGIWvFYQlZNIlggYJ1iCQRkaPQYWFpUQPaBBBNWlQo4geUCFogwoaNbDXIKo7CCqIKHIUhANnTcKCoIEaFEQQ9jA07+1bm+XherEg4uxj5YKPs//1b/mX59x7ztHcf6NisdgAu0ul0i6OdbazF4FmEugSjLEOYv0BdnpLtiJIp0PdgHWwA/rgGzR6W3wxfDashPfwlIxVbqm3GIahYCuuGKwz9UZnTmLd6VYivOfQ6zKeyFPD4LcwCFcc8JHbQdR18AVu24onhm5wqLNQ0FpifR7qQZe9B77Dav9YPDF0szMFURfggcsg6q9wyD8SVwzOwynogE22denXU5+Gw1BvO3sRbAaBmkGXWGfzOhyHZd6SnQjRBM/CdUWsh2DY6zHQZ7TW2+OK4VvKwryDhW7prG6XL+G/gLxbccTcJfCRwa+hKyThM+i2wl8E6SSMwBO34oiBeqyNwgqCLeCob+199ahrWX+Cbu9tV3qO21SnLgZVg27Cd2zJuwr6zOmN5qgDtajHcg5rfTbvhs1pi0FNDnDAlrzlIHVBP/SxpfzZ/BgGXKYrBrU64FZbQdTdUKwML1FfgxGX6YpBbQ7RZiuIusW+3m6qbQdRhy+Sy3SlYA4yISBWFZ7eA8/YSjQlAkp4+2CRy0RTJuDPNB2wXH9TwAm3mV+JvZdjBgwvrBz1p+Ux25OKbXrs6RVMT5lR2+mLYa0wAP22JhX9Rv8yuok32I4jBj78jYAHbcXTdMA/lQMOMn8+zLMdRD1LPv21HLMLqOES6yHbQdTNbgVlEpC5++Ecw3sdInmDYb3H3k3vWeVWfDF8/A06uY2wPmJvqa3sRIi9DrPGlrwL9ubayk7k2OgwyT8sWd+Czy6zFUHGbyX34IR5Ca+8JVsRJK+AlcLv8ZbsRR7dCyupcftfVi73A/UXH+Si0TQpAAAAAElFTkSuQmCC"
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.salwar-kameez') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Pant")}}" class="item ratio-1-1" title="Pant">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALQSURBVFhH7Zg9aBRRFIVXgkIQNWopWEUiCDaClYqKNqZOUiiijYqNAQURmxSKSsBSCQgSRBIwINjYaBG0E0zlD4KFthYb/yCI7vqd553HOPtmI8zbNwQ8cLj33XPfzMnszN7ZNFY82u32VniqBzxhp6iGVqs1zMF6gUU7RTVkBonnCLtikGM9JkY3eJlwiHjATrITbra2IOjro2eL9e/WfjvGU2Jcg2VA/wTn4Bm4Dg5SniDOw6U/XUFEv4LXCCPEUXgaXoKT8BFsqgcskv9UQnwPp+FVeB6epDwikj9Tr52iGjhYZnCMsLFI6muJ+iiPwLdwjvV27c335UnPA2Kyj/i+tWaGVtlS626IfgX1V1/Pk9pS3mAR9Gjfy/wekdorYnSDw1by0En+weAtW3poj/bashr+G6yKnMExKzlQWkPtq05mJfXegMdtmRmctqUHtYdI0Q3+gHfgEDwLP1p9Sn2kG2z9xG0E5F+sNk/YTzwMn6sGohtcgL/coQG5vvOOkfZZ31BWdxsB+SZ4BX6WJpA34QfS+Pcg3AF1FY9ScsYyUDuoPtBxYjRnFG0CDpCneUjyQNfVdCDvt3IQdRm8oD6BfJuVg6jL4E31CeT7rBxEXQZn1SeQj1o5iLoM+vc/4riVg0CvxeA7+MJ6J60cBHotBr9DvaB+g/esHAR6WoPI2RTRqNOV9NMkBPS0BtGyKTIOdS/6aRICenKDbooQ9XtlZrmT05PcYDZF9pC770Ni6TRBS27QTRHiYC4vnSZoyQ36qwb1IqG8dJqgJTc4C5uW+/vRiQGgJTeoJ/e15f6JdmIAaMkN+u8+4nrrL50maMkN/jU9iusi0NIZRPJTxEra03WaoKUzSL3jniPXPfnGlh1A64nBu/BigLdN908t+QzUxxzqFxeiG1wO9O21Ldrj3667II5BDrQadvwLLUD/Kw+D/QG9yAFrX8loNH4DosV2eo8GvxEAAAAASUVORK5CYII="
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.pant') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=T-Shirt")}}" class="item ratio-1-1" title="T-Shirt">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAM3SURBVFhH7ZhdaI5hGMf35WtCkSIhB1uUaYmVUhJysMIB0jTLx4FiB2otRA7UiqUdUigOhqQwQo35mI8T1BCllNVqWRKb+drH6/d/3v+eNszsfd73QL3/+nXd9/++nuu+3r3Pcz9vy0hUvb29k6EUauE5fIBu+ALv4CHUwAoY5ctSp1gslstGK6EankIPXoz4Ge7DBTgOp6EO1HS3czrhBlQwLYRMl40mCmVTdCM0wHdtJjHW5pc9rnT6ALE0krW7oOb0V25VvsS4jXCKON/pwxcFZlOgKaiIGD+DUoZTvJ7FvBGko7AQJsJUKIZHvq7C+ZmMC2AXdHhNOsEwVzn/LC7K56KPRN1PB+EJNHk5FN54qNVmvwq/A8qdGgpP924PnISLzr1FGOGUv4vkUfASPsECezUqhCYESb+I9VmwHfRh9pO3jjjOywOEvyReKrbG8z2aEA8HCUPJG+iCzbbk7ZCHFttKWNTapELEIlvyLkEXdqGtP4sk/SW+wj2SwyeN+XoXXWsrYVGjRLVQ2AzeTNDD9AB/8CechKvQBQW2AjEvU0XialsJixp9H3aprUDM+77qLbYGSps74YitUHg6v7Q2z1bCosYi1yqzFYi57v1X0AaTbMdFvg7ht9ACv93ceNfgPXlZthIWdcbCDzhpKxTeMjd/zFZcGFVe2GArFN5c0LFQbSuy2OoO9ZqJvx0t+Oe8X/whIkkH8je4GRj9xJoOY924ar7YdmRRKzg7iXtthcKbBu0sP4ZsGddBL/k5zgmFt1OFJMapaFAnRr7tUCzt9vo2JTd4otfWXOfInw7t0On1pDYIug/1zd2mfP8jrQSC9zaxXN3mMKgE/SrREXMIdCNfARXpe/yT/RfUq3Sfa2+FPKj3/DVhudPjwtRhWecE/dpQrIJij5PeIIxgrB8h+qb0dYsDMPjvRxZXQTO8oMBoYkoahFaPi0CN1UNekDCU6CdHn05jLkpFg3r3Nnuq+RgPh68UNahXathgJKUbjKoUNXgGWjyNphQ1GBwznkZTusGoSjcYVekGoyrdYFSlG4yqdINR9T812Eg4nwyopf8qJKdBCs2gYBO8STJnvcX/rIyMn1CcJM5/1SIAAAAAAElFTkSuQmCC">
                                            </div>
                                            <span class="keyword">{{ __('text.t-shirt') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Shirt")}}" class="item ratio-1-1" title="Shirt">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAQ3SURBVFhH7ZhrqE5pGIY3o/Y4myhTYiLjxwjZwoTwY2RK2nIaQynk8Mcv41QmRUp+UI5jZCLnwyCUHKJImHLa5IdTjOMkx3E+7O26X/dafcu3se3v+zZp33X3PO/9PO/zPutba73v2jsvGyguLq5ZUlLSDFsAW+E3gdUc/jSgkdZwPjwHi2koAaRn8Aj8HdbxtIoB63/DotfcyCE4B06GY+BYOBUuhReds8ZTKwYsuFILC/g9LaeB2J9OU15/y7kBa+gZGw8PecFN8H+4j2EVp8VAa+L4bngdPoEb4WBi9ZyWGbQwBYfCo/gB+LdsdRsn2J8H8z0tau4YfAz1rJ6ADzR2vp5PXWCBp3w8mFwdblBBAX8f7IRbFXtNY3xdQLjd2JtwO9wLn8LncBCsD19BvVA1YT/4n+c8x4zykmUHk7RwaA67CN6Cmx1W86ugfp185251rn6lp/aHObfQ4/AM4uoCH8JdMNwZ7BDFygwmTPTE2R4fgOdDEOCPdLwrHGf/IKYutj32HvYOth1Wb7i2oQae2whf+dMxtbCn4SPYJhT/EEj8HuoZ2U+BsNniL4EvUsbNvchx29CcYgLjuEl4CRY5pNiPnjPC4xZQv/w/yGkvWxpIXA5fwB8sSftNRUEzS9KuSMAmmouAHpp0zlzL0ntZ62VJ2mRrhZZKBzkNSNKvt9FSAOPhLtDRkrRpUC/FO08JYu1hEexsSdpA1QJdLGld3eq7cI+l0kHCWM3E9rAUwFh7l/R3bsplRVQLxA0K6Aug3vbvLKWD4FH4L5OrWgpA+0UVsfFtKS+oEV1sW0sBjDtYn2IpCQItnTDDUgy0Xx3rZqncoEZf1QLdLcUgdgae9TAJArM0C9vCUgy08Y41tVRuUCP8UmCApRjEopOpk6U3QPsKUeflQUsJoK+DD8hL3PrygBraK/WsTbcUA60RfAn/sPQGCD+789GWYqA1hzr0l1vKGNQ6BbWHpl0w+g6oTf5rS0FcAXVElbaf7XTz/SxlDGqtds0xlmKgRc9730jIh/fhliCkAG2QkgX8jN/gCNRa5Zra+xpaDkDWnqijb20k9HFy4sBGqoF2Fb50PKsNqi7Us/iX5Rho+m58qB7UyDIGOj1qOx7AeKobW2KbtQYpt556+q7U2mry7T0x2ncLNbgMDzsWQKweml6M/TDt7MwU1NIRqXUbQ322bXMogOW+9ZqzlawrWOxYAOOhSgA/4eesQfsLoXpInOmMb8DN6laLL7QegDRJOtCney4a/BuGBikdrxWChuJw+6dqUC/JbfmU/jwbpOQ9+djKBj8a1KpsMCNQq7LBjECtL69BfW5dSOHtMKUCG0RTQ6k96G/zbUqYiaN/kSWIvgxWw89pg/gtoc7mt3vQ/256hwnvA0k5bTBjpDR4ALM+G6TWZWx2GqSQnsOTMPX5yAYr9v/WuUFe3mtQ3MCSbnZknwAAAABJRU5ErkJggg=="
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.shirt') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Watch")}}" class="item ratio-1-1" title="Watch">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAPQSURBVFhH7ZhLSFRRGMe1TE1Te6AStrDaBBlltU2RShFKkjI0TVv23ERQ60g0KF0Ekb1W1a6NFLWKIHs/NCloGQT2poUFrazf//DdYWau09w7zgiVf/hxvnvO9/3vmfs4997JmtGMojQxMXHUwpSVDo+E+oUsTFnp8Eiov3KCdOVz2mpp99AeERarL9/SIqIv8xOkmcUEGuEmfIf7cAX6GOulPQ/34BvcgEbVRHtkRDJnZ2vhKbyA3XQtsGGfGC+ENngCqqmejgmOQTuhjmIxFIEmsRl2GfXWp7FicrNpd8CYPMwuvcL8OIziXwm5xKXQDFugiL4CS9UPKYASG1NOqdUshtfQbanpEYb7QJMrse1VsN8NRok+dwRtMyLlQpXF5aBJngFdn/34uuszJWFQBTo1lbZ9nXi2Gwwh1ajW4mXEn+AsPIAulxRWGGXDXQzaIQ+qwkyO/NWqsU355bCto59H3EL7CvrhsqWEEybbKB6m1Q1RBgdtKKnI1Q3yFuqsy0keoGtSN85LeE68wobDieLb0AG6E1usO5CoGYBzthkj+nfKE3TNDlp3ODGheRRrEV5o8VYbSipytczo6BVZV4zob5Kn+Y7TRlaAwKKwDoYs1i8tdgNJRJ53auutyyd5QZvFQ9ANWluzXUIQUbAXrlqsRXiuG0gi8i7AgG1OKnnJ0+KLMGr4lqiE4tcco+C0Ylrv17o2kRjXM/knTHpqpXgv2h5h++tRXyDFTdD9Mq9NJMaHqNPjsNa6fIr3Il0vF+EnSHL0KW7AINCFTG4tfFZrXT7JS56KaXVJeKf4j2coRiRH3yStEOgmkcitAU2yxrpiJC9otVhPkhPQxsSD3yQkawn4AaGXGYl8b5LrrSsiecnTfL/S5tpQOFF8C/TOJ6Nm6w4s6tZRF3nUeZKXeWr5GobAZydGFDbBCGbeo+6ADaUsPPSoK7P4MWiC72GjSwgrCu9AJ3gvCzk2FFqqlYd56ei9AV0Ko5YSXhS71y1YbttTft2iXQIf4Au8g06XlKowiH9hXQm+001fohfWQ+CuRTzmE2tJOQwVbOs6rXCJUxEm7pUflmI6h1ZvxttBd6R2GnkUKrY+XcPKKbeaCtAr1ilLTa/YiZ4SuqB1Z+vG0VebnqutbG+idUfQYq2dGitkW+9++oj6SJzxr7pq0GfkCHTBIhv2iXQtJZ20z1RDu0YeNpx+eeY0OiINoI+ecXgI16APTsIleAT6cB8EPSrdU8LzyIgmM2fnWjK0VOhour8+LN4AeZYW0bRPMKz++wn2Wpiy0uExo39IWVm/AdBhLFwUgwRAAAAAAElFTkSuQmCC"
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.watch') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Mobile")}}" class="item ratio-1-1" title="Mobile">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJGSURBVFhH7ZjPS1RRHMUnkpCEyk0SQUGhCOKqFhKFm1a5bpELWxUK4dZW4apVUOAPCKw/IBe2KiJoo1BEK2ltKLRVc6EIOdPnDCcdm2fz5t33nhbvwIf7vd/7vWeODPpmLP1WpVI5Xi6XJ+AHdWJx/yd8pOy2dTrC9J5f4B08D+AlbMAnW6cjDKdgk4wtbiUWPjOw4206wnCacOuu++Az+y9NMl7jVVGdmmoDsj7UC9Cbh/cxWYPFGq/sA6IL1cMY4r5+mCJgSMA3sOD6CaxWD9JSaEBmu+FmCGTosl29QgJy94Xng4XXhG33K2lA7l3VIOssy+0Q8HjNKq8e2+8pIOAdDbLe8L6NbXuTtPruALW8BrTfJ5pJAw569jp1B+hp1JS4o0fjKcg8YK8K1jkYi8nb6m1eizq3gCM+bijGd19LwVRo9fGeaBYBo8R4EbAIWBXNImCUGP+PA/rClYPgvBfyD0j9QIONxNwyHEpAPbjvsr//N5gZFNRSfgEPEjOd8AF2A1AfqYCjNvjqVq4BJ0Gf5U64VSfO9dY/gmtu5RpwyIf6x8+rODA7DfkEpH+Mg8ewAqsxWYR8AibVvxow/Y/8SYVZbUB9adr2Pra4o1/O0wrmfTYBtWfV18hLf8Jcl4g6g3Z7ZR8wSpydYe47fIM2t+ukYDLS6la4MGsYkJlzsA1bcNbtOnGWScBbNh1yK1Kc6y2+7G2kOB+2V79b4cJMTxe9fTsQ9beyGaQlMp60fTrC9CI8wzjyiRMXPJ7CeduiUukXDglibw2rkgYAAAAASUVORK5CYII="
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.mobile') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=TV")}}" class="item ratio-1-1" title="TV">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAADwSURBVFhH7ZcxDsIwDEVzl3IINhg5A+dAgqUzTKwchRE2zoC4S8K35EpRmkQpLokEftKX2jqNv/9moyjKBKy1C2gH7RuJendsZwyKL+jinDu1EPWGnmxnDA45fmxG1sNQxBTbFvI9RMkWK1Fk0J+oBpqgFE1QiiYoRROUoglK0QSlaIJSfjfB2vI9RMkWK5H1gCloqztDsZWwhqh3eqtDsYN6DBFdCwPdcfYR+R6q9BytnT15YDvTwc9LaJj2Ct2895TCcyu+bn4w5QENitJIiNI88nXzgwZksCS1lCjNrxpce2l8JBjc8HWKovwBxrwBnfivuE2sfMYAAAAASUVORK5CYII="
                                                     alt="">
                                            </div>
                                            <span class="keyword">{{ __('text.tv') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Jewellery")}}" class="item ratio-1-1" title="Jewellery">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAT4SURBVFhH5ZhriFVVGIZHx8kybcxLpE02KGQo0mW6p3SBLNBCJaMSGh3FwoKoP2WiNJQMFWaIodnYhcy0MHWGEjMjo7RRIq2cSDOQrliSmVmWnel5v97jj+rc95kf9cLD+tZa32WdfVln713xn1ZHR8cVMD0Hg+zeuUqlUlfCURaQVfjspuntsM4RBQdReF+sAGHfSlP3N56FEPOv0VQ6vLyiUA8Kvg9HYBJICzwdwqcrY3thBzR6kXM9XV5R6HkX3Az3wjfwg+00C+zzBszEPEArTXCa8ohCPSnyq4oXI2JbnKp8osglcMgFm2EI5uB/g7kLYDu2fN+Dvk5THlHgcmhzwbiDadfS/OMuZayOuc8hrT9gKZxml+REsSoSP6Yq6HuYxVg/2odjJJXaBWfbXT9kKvwCujbHwHBYBlrkfmLH2bV0kbAXbCKpjtYqOMXj1zD0Eu3vnvsZGmCp+hL2d/AI5mDHjILPQJqlsZJEEi3u3UjH3akxip2FvcELOAgr4Db4SGMS9jMwE94GSVvSo3AinARv2m9OFCpWJHjRie5QH3Mc9k9wGBqhTzgi5rQ/ahH1HgrRHwFrnGc7nAHdQZu3xm6wa2EicJoTxCZMm96UP4bh4VSAiKkHXQZfQA2pq2k/gR+xa+2WnwjoTaCun3bsKhiJrdO0A7uf3QoW8VeBFvkheXrCOdhHYYVd8hMBcwnW0dMDwQmwG3T3DrBL0SLHzc79uPuLIMVQXTjkEo7d8P8WNqtPe78SoonhkIDIuRJ05IaRVw8e2n6WeDq7cBz713o6JoP2v6/hA+wudilZ5BsKWtRi91vgIDWOD4dswnEe6JBrIx5Nq9MxzdOJiZzrSH0AKkEPtqpzqaczCyc9pbTbbnJg4n9P5LzTuc8HnWrZ93g6s3DS49Nq2+tgb0wkLPJe6EVNpelme6GnMwsnbSfNtrfB1phIWOQ93YuKvzxa7RIrYzKT8O/ioEXq0+qJ+J2YTFjk7e9aje7rzLXGZDbhpKeQVbZfh10xkbDIO8ILvJ2mklbbzjJPZ5YWBFtsPw2HSVAVkwmKvNd7gdfBQNtNns4snF7BV7f/cdj1Dhzt6cREzsXwG/SBMa4zydOZhdNd6UVBX9Chf8rTiYh8eprRH8BG9590zZpwyCb8anHULp++UV4G/dIh4ZCAyHW3F3QTja4/LbbN07mFs/Y/PXUMgDNBC2whWcl/d+SpAW0p25SPtkGLRdPtklsEnQvH/sBpH3SSB8KhSBGvh9o20F57kftfmu52y08E6CVH7xv6QKTToD90aTb9go8kcbqeNxKrU9vgsfnu3xJOhYi4UwnU06++wegdV+8Srzrhapq8v1rhrxtuD+iGi/9b4vW0pFzLw6kYEXwe6FrcSa5a0JHUq6YKaUNfCJcx3tUhx8R4L8Yn0q6n1UL0hH6t58aDTvNWpnpEQLEiiTZSvSTtg1EeGwatoMcyFd8P+qCksQ2wE+ITCe0heAizGnRTzAapHXJvK/mIxPpKoAtZd/MT0F/jKgAzQO/LW0CXxKewCZbAeGLjCGFfrHH6WrQulWqNJyaSDoRWF9Cr5zzMkZDxux8+um5vhDUg6UzMyRZTsihwNQXeghB9nfr18Bw0wXzQy7xe+I/YR9drM2Z8YegUUXAoBe+j1eK+0kLSoq9LQaf6BZjCULKnsxixCL0/nyw89H9QRcWf/QKLXnCmjCEAAAAASUVORK5CYII=">
                                            </div>
                                            <span class="keyword">{{ __('text.jewellery') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Panjabi")}}" class="item ratio-1-1" title="Panjabi">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGYSURBVFhH7Ze9SgNBFIUjFsEq2hmJldjpY1iob2FhqSCIVrZWQgSLqG8QTae9GPx7ELHRQoWATeJ3luOyqLERZ1aYDw6Ze2bCHO5ssruVRCIRgMFgMNHv94/RvXUkz9NxIcgoge5Qk/Ekn3W0j24052XxIMgyunSZg9dFSy7jQYgNtOcyR57mXMaDEOpg12UGRzuCd4UWbcXD1+AtaqIp6wBdl+IaFAQZJ1ALffyKW3g1TyeGQqem0Sl6Qa9o3dJYXgfNenlY2LiBHtAm0n/fDMd6IWlsT3Na0/DXwsGmJwrgMoN6XnKZQeBt1HYZDoLoGOsuMxQGb9dlhtagZ5fhIMxAn2yed60Y8JOfrQ1KIeCcZK8YsOhHDfivOrjKeO0bvxwdLFL0YwfMO1Wk6McOWM4OsnkPjaEfO+g1PdvhYFPdZ/UEs4CGdVBzh6hjOxycWo2N9aL0iHZs5+BtoSekF6h4j15s/uX2Job5wUkBf0sK+FtKH5AQK+gMVW3Jq6JzzdmKh8Po8f+NrmV43NaclyUSib+hUnkHSIGE1ZEUGgsAAAAASUVORK5CYII=">
                                            </div>
                                            <span class="keyword">{{ __('text.panjabi') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Shoes")}}" class="item ratio-1-1" title="Shoes">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAASCSURBVFhH7Zh5iFVVHMfHJdGa1HErnT8yckEUZDQRMQMNREoxGVLS0gxR8R+FMEUHFHKpvxRUTBFTMtERg4LB3KJGiVDEBTOxBUZnXCLIKc19ps/38H0X543vzb3TvLFgvvDhnPvbznl3Offcl9ei/7Nqa2tb19TUzIA1MNbm/4aY3LNM6gBtJI4/svvxiom8Br/Bfea1nLYjfO1JznRY84lx2zHwaCikX+qJVNC85BBNeoLt1fCMzbkV4+WrZcDJHvw2PID1HHYKQRa2FxRjLbe56UXxzmoZcJQnUwZ3NSptBbwYAtOEvUgxEv1TNjdO1GhPkYHq0/YCPYU9YRbch4Nww4Pdgh1wDK6EAo8QvhLHn4EHdNvY1bAI7kaSloNFsBr2wV34An5Q4YeF7S/YBeeg0jWGwuJQME3YdY9ehh9hlWqgAruzi4Qx8IeT6gj7DTgNN+EivA0n4JJzJ8MRQluHYhlEzBLXU/469dETdmcXCb/CL/AK9CSxQNC/BOWK4Xgb/WrHF0OZ+nFE7ADQbfAtdVrRHoYKu7OLBJ163ejbbYqE73Xs89Wn7QrDgyOBqNGJvJ9AV6Afx/m0f8NOhzQsgveQqNOvS7cBiuxqtCjXljoj4SRIE2WnfddjTQqBcURwByiBciWjUrsSiTxdvoVwFm6rEK3O1iz7NekLUEm/XUhKIhL1FlDRj21KJPLed/552ApzodBu+RfYP9emZCJxkgvMsSm2SNPZq4Kz9Outb9j7g+7DY/jb2hxfKgrfUECXJPF7kpxh5OvHLbIpEmY9KFovNcGw+CcSBbQtKvMAJTYnEnk7QavBczYFcfwUZfXDpSk2NyyCC2EqyaW0OmvSGo6zLrjpIl6vxM20+nF1liqOn4bw4NEutTmzCHoeNsLPSpLoa3K7YZTDYoucvnDSdbbSRE8mx9r/HbVvhc2ZRZwu4++gy1AOK2Ec9rBdSipyp8GfcJMa79gchE1vDr1zpYU2ZxeBb/nXFNvUKFFCl3STa2kSg+zSGD1gGeiqVBPyhl0Ni4RXXTT+Cp4mcrVUpC7pDpp80OKrDYN2Pak94QHo47R4Iq8zXCdR90XsfRjxXWAKfAZ34Bb5s+0bAec51qR0uT+hG23xE4sCqZV8rU0ZRUwRfAmps6K94V7oa/880Mb1KswkpH1I/Lei2C4PmPFS45sOGlxnZQsUkxK2+RL9xa7xHfSwuWlEXW13tP+7Al1sjoRtMNwDDd7d5kjYUrsRfUI+aXPTiuLamEqf2hTEgPoX4HvQdj56yaeETd8k2mGfIbbOF1uTi0G026hhoHBT02rjupZWZydsUtOF60P7h9iUOzFId9AHdCV8BVUaHG2DR+1G9DQr/pBNuReDha8r2mug74Q3OWxldyRsOrvySyNszr0YbIgnmHHZwa37covjPrC5+cSg++EO49dbYLHrhf+5J7edpt7ZzbkYtDeD618ovfT1L1Q/6EN/Nq3+/NHkVtM0/+RSYgLaNh3XZB6WJgjjHfZ4xXz0TfEyvAcLYCy2+P+dtKhFmZSX9w/HihG0LCS6HgAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.shoes') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Bedsheets")}}" class="item ratio-1-1" title="Bedsheets">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALtSURBVFhH7ZdLSBVhGIYzhQoDM0gOCaEVEUaC2oWu0EZqUYuEFkWEEIVdCCTT6IIQWuCiCHEXFFaLiDCoTVFEtHFVQQXhwu5EVxcKJnVOzzvnmwE5k2eQ08wI54WH//u/75v5X+f885/jtLzyyiuvEJVKpQqhNEJKzEqmksnkcRimKVLhYRA2mK20SKy24hOGc1HB+l3wCd6ZtbRI7KdBBmstFZnwcNq8zLeUk2yy5HJLRSZstMkLWmCpKWyQVAFUkN/CuI+xGfQynYQWy22HJcRFdpnuVwwrYTccgFY4ZeNhaKR/PZTaJZ7IZTdIWEB8DD4qH0T0foMLcAvGLJ1V9PbDJscIIpXdIGODzZ+D/vIGWAGLoJxSAhYS18BmaIH7IOmougx6uhthmfXOZayApcRrYA9chC8wDMVam3qgJ5jZFED0D3GPazYNJK4Ztxbj5A1SL4d1sA0a4Si00tcOOsdG4aXFJ1SDI7AL9KRrqM2x2zliPnmDzLWhu+EpjCiXC3Gvr/CQsJ2xN50NaBAWw2OnBRFLL6AXOqAJtoLe0mpatL8qGb3vVObzlDfqmK+FHaBTwH2RPlPzxPwMzCKc0OAV+AX6qK6DXo4ya8u5uHcV6Bjqt/Xfwm3FKNOgRHwPKq0UmlhTe/S92ZDGGWxWhvEqQ6GlQxdrJ/AwYF7SD4l4OpNX8BpmOMkIhYdV8Ac63US9Od7rJGIgvNyFn9gq0qRDBlHC6pELTwfNU50+4kckBq0WC8mY3OHrkNwOwAOrxUJ4KzGDXTL4HW5aLTbC02+4JLdy+obhRpzA0xj0uQb1zfEjZuioueMa7LEnGxvhSV97U9Qg83ropuS7P3IJ6+hHSSdU2fKOmPsbJNY/Q8rpLfLbGzmFpYZsvRGoNhsTGlThGenZlvrvYr1a0AM5byl/g4QziSWvMSyx5gfos+k/Dbon+FmnK0R5hkze3Ay556B+QURpUIezuz+9c9Dvzdpp14Um1uzJ9JJq+wuUv794MT1rAgAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.bedsheets') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Gadgets")}}" class="item ratio-1-1" title="Gadgets">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAANfSURBVFhH7ZddaI1xHMfHGBdaYimal5hdeIvdWETSuCBEpoQSk+1SJsuN1JJpoSlxgxspygVSGEoSN0K0cuVlRMnyMjMvOz7fZ9+ddTxnx/NcHMs63/r0f/7f3+/3f37nOc95/s/JyymnnAaiEonEIKjs6upqYjyXLVj/LNTDHJ/676KwgIIbjAnGH/Ahi7T5PD9hp1vILPIPkCzt4rjAdtbEecbBFfgF5bbTi4aGkvQa3sDuf0iDr+RxtxIWwRJ4qsT+FD2cYsh3W93CGEzgMXyB7VCKN/kfM5vznmBUk3vdWrfwFjmww1a/iBYG0cNteG+rWxjb3GCZrX4TPexzL2NsBWaNzZm2+k20Uade0ARbA6BBQvnE5sIqjZo7FFnUFVJXwbgCptgOiZx4DeKtg1dBicVcz8p1Tsko8obBYfjm8kDMb0Gp05IiFL1B5tUgvYBa0KfX+Nz51U5NK1J05a869xpsgTWghjtB212J0wORGq1BjouhAx5Coe1AmsMDx4tth0Ss2us22EoKrxzU5A1bgUiP3KD2YnkLbKUIf77iqM5WSOTch5fkDLWVImJHupdITLYVq8GT8B077QsD/hDinYynbYVE/DOc9zQkYmt93uW2YjV4zN5oWykiNJKY1OcGT+wtNHsaErGtPsdiW7EaXG+vxlaK8Hvurw22QiJ2AdpJm2QrKTxta9ehg+MRtqM3yFSvXi3wCZJfgaS5/Rby+nxnJK5np15GdS9OtK219VLc6HMetB0IK1qDEvPp0OqYfrVnNHquZ+EMp/YpcqpATbZDM6V61e9Z8xJDygdkHr1BCbsIvxGegW56jfr0RU4JxFy7hB6++p8x1nYg5rqS50H3pF7p7oLuv9COhBevwSiibhR8hDbQq/tlh2KLNrLSYK3rl8BRkKY6HEssk7bBKjmMc21FFmXazrQV6srpa7zjtZqcEkvU7Vc96r2FMOfJYay3FVnUbHStvuKev5PaAnW/ptyLfxPL6MnxCFpt9QrzIujXdgiWkVyRCXKWwh74Ck/wkr9G5mWgtfSY2vRnbTrIWws3OZY2e6leERxNQP/4Y4m6ezDeyySFtxLeOS2SyNeVz/wHnoRpsJr8ykwoB2a5LK3IG07Owj9r00GevrWUR1dOOeX0/ysv7zeuqsq4HiikIgAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.gadget') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Bag")}}" class="item ratio-1-1" title="Bag">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAN0SURBVFhH5ZhLSJRRFMfNSoo0ih5Ggj3cZCLkIltIVCISQWT0tAcZVlCLiggTRMNFEEWLwCAQCjSE0Io2LgoCcWELtScVVBiRYPRCLLMyp9+Z+Q+U87oD801Ef/hx7zn3nHvO95iZ75uU/0JjY2MZUOrz+SoYd8By5qla/nuikRy4AiM09IfwDUANTFV4ckXhjTAEP6AZtsIKWAmHoEuNPoAFSkuOqFtC0VF4wnyJ3CFifTcMw3OYJbe3opDdb2/hBcyRO6KIWQd2MM1yeSsKndClK5UrpohthJ/RznbCRKEeeCrTScTn6aBq5PJG1EiliH0oLsrlLHLeQZtMb0SBTJ2Jk3I5i5xH0CHTG9FbtjWIquVyFs09hE6Z3ojGplCkF9bL5SxyLsBZmd6IBidSxL6IM+VyFjn5sFSmN6LAJbu+jO8h5ndgUMTar0xQcZ/9sGKjDXALbv/GsDUodY9bi8Zr5djBvRq3dgPmq6y7SOqAr/DSQ/rU9DGVdRM5aSTZb+hluTwRdex79QO0yuUmEgp1ZJVyeSZqtEO/TDeRcFQN5snlmahRa7XQQrlii6RW+EiS50/F1Cm27hjL5Yotgt9Au0xPRW/p1LLHsQa5ostOtY6oTi7PRa170CMzugjcrgaL5fJc1GqAUcqmyxVZcQUnSNTb5XxSiLNfiPsykyLqLVKDtXJFFkGfwWRPzudgE7nZWk6I2G8S+xbAQWiCfjUY+72FuGoF94Fdar+Y23vuHWjErGbcDPZkU4C9GGaDPY5NhyzIBfvCtzfAvXAKroJ9IL7g94u5vboOaJ6rNiKLoHp/ps83j3kG42rGKrgGz+B7YDl+kTsIdmXsJWof5OO2R7gjgQjfMrURWQS3wKDMELGJXR77R2ENlMNhaArsHxD2CNQxPQBlzItgrrYIEWtrlbdNrsgiqJfYbplOIn4yeW0qYg8Z+7XkJOKDH5LYb30E2T3RIjMuUcN/W8h0Fnl2mb9Bk1zhRUCWjqRerqSJmo+hS2Z4EbBKDe6UK2mi5nX4JDO86M1uamuwUK6kibKnVTvyuw6LZywIzZAraaJ2pRVmLJIrVCzehCHiSpINdY8zmirUTqgIuqugvyZ6qFI7oWIxh5gtBvNOJfQEfYmEffcw+sX8PIP5y8DtKYqkaQTPdE6IU+w7QfsbaXL/a0pJ+QXbIiC2E4IP1AAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.bag') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Oven")}}" class="item ratio-1-1" title="Oven">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJbSURBVFhH7Zc9axRRGIVX0DRiIUoQ1PjRpJIUAQ2C+AMkIGIwTRCEEGwE0SI2WkmsVBBT+NEIi6iFgQREkka3EEGMBiSFWsQUQgRRUBOM7Pqcy5mwxBkXYXe4whx4eM997+S+J7vD7k6pUKFChVqsarU6Du8j5B0MlWoIMw+TkbEIE0nAUb+g0YhMc38EpA6yvJ8XzDuqufjN+OtwEd/mLKkBZ2AZPufAL3jquVeVQ8IPuZcZsCLfatXPop4P6RA+vKrUeAISYR3+BBwJmwgfT8A0sRfVW9wFr+AJcba4F1XAW8oh4c+6lxlwntYl6mn1minOXQvDPn8BkoADIC1Bj3vpAbVOxHob7AN9squ22/f7+jE4Z38Fbtifgkn7XnnYBT0+Ooj1yruF74StXmqd+Qo+gwvhhFptJ/6QjGuHPBrW9dQv9Mv+2wrM2I/qIvuT8tQ9cMB+EN5AfcBNsMFLrbPvQeh1/w6M2I9AMqxM6aN+h4r9LMzZP9Z19jdlqGdgzH4vrNyDtA7jf8JX6HKW7IC01lDvaq/Z4txr9bPsb3s7/CPuZQeUl9jaDd3NgrO3++jVAffDR5jlug73GgdspRrNYq8I+Fc1msXe/xtwmlbqTd5MmPMW/jngc63zEvMehTQpygrYybIvL5i3I6RJ0eqA+qDcGBNk0pPmhJIu04hSZHuogMfhG3ygp59Br715Wes8YNY4VTMfQHiAor6kdCfv9z34QUOPggvUF2EjJzFPv5qkaZhirYDHvB0CHgR9F+px8BMMeCs3MbPs+UI//9d7q1ChQtkqlX4DUMWLnN78CGAAAAAASUVORK5CYII=">
                                            </div>
                                            <span class="keyword">{{ __('text.oven') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="list-item">
                                <a href="{{url("search?string=Furniture")}}" class="item ratio-1-1" title="Furniture">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJaSURBVFhH7ZfPSxRhHMYXCjp4EBI8eFHZg3b3kFAE6l2wungLD931kAdBIaOO5cWLkj/+BinIIAwx6KYXUUivUVkeLZnt8wxPozs7oMbM7BzmgQ/v9/2+7/g8zs7uu1spVapUqZxVq9XuBEEwDk9yZlzejpEsNs3BCWzBu5z5BPJ+5Tj18p37Dbfdyl149ytD4p1kYQI+e9o0KQMBJz09k5osfvS0aVIGeO7pmQofkOYs7BB0iPEeY6uXMpe87CnvHXjppTBYG7xnsU70vjJ0eVtmwqfbXnWitw5t2rAC2/R6fY16N2CXXuPDmrLw0ZtzV55uqXcL9GouafITRrwWiV7ys5CydBPk5Wkkeg/ghzZIDZ878YDUo9DiehjaXQ9C1XWfcF3Vmut2GHbdAqOqJbwTAyqTgl0lYPBvH+UhhCaMG/DM9apQzV4Zb7ivf+7QfR0IgWrJ+1IJuA89qtn/AYbcX4bHrvVJMOv6kdZUa6+ucb8H9lVL9NMJmJXwvjggGzYhfnjrzXMQ62WBXhl5xfub5wOuM7woEs4UBbzrO1sYKVMUEDU8g82WMilYGfB/pUwKFgbk9Z6HpN8JeaATR6fL+d9B1Sggk++gwzr+Ns+LAeiAtVjvPnxTwNeg72DhKVEEceN6nWlRAW/CW93OIolMb5TNmcPPnU7QN5M9WGDPQ8ZTxhnQWZoFM/aQ14K9laHTsRrF4jGMwFP4wsXXvZS69LflYS95HnspWb7gFKapfzGOeSkzycNe0/CH+pqXksWmKTiC5Qs3pyB5yMueU26XKlXqcqpU/gIkO9m6cMchJwAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.furniture') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list-item">
                                <a href="{{url("search?string=Burka Hijab")}}" class="item ratio-1-1"
                                   title="Burka - Hijab">
                                    <div class="ratio-inner">
                                        <div class="text-center" style="width: 100%">
                                            <div class="icon-box">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAMCSURBVFhH7ZhdaM1xGMfPGTmbTSzZXEmUl7lBroQLLsiNEndrK25RR7ThgiJK4gKTEOVt1GrlQlor5aUtkZfROle0aIxIsc22c3ye0/eczjqn87f0/FfsW5+e3+95nv/5Pjtv/99Z5L9QKpWqTCaTG2E71EGNSuMrBpkG52CAIUeJ3ENYotbwhXkMHmuegqL+BRbqknCF8V7NYYM8IKwixoj2ctfCx0xNl4QnfEswfqsBuglTVMqK3FKrm+hZrXQ4wrBG3mZ+V+lRIl+mFuu5oHQ4wrBW3mbeCzGVsiK3Ti3W80rpcIThbhn3K54hTFLZ6tU2lGr2QRlmWaqyvzA8bObovqIN8gJOwEX4rNwvaEo3pFKzdbm/MD1mjsQ6xT7IfGhG4JPWLRDXOryvG8yOynQWXNP6BmyBDdADg6QXEXeovkCX+wuzBpkuJ5QSL8OI5XJFbhC+ajtDl/sKw5Xw3RyJT6Ha8mznsq6HBvEGhqBLvfcI2Q+SmzB6AvbVchBMH2A/zGeAEpjKOg7DcJN9FBrBhtymh/ERBuVgOqu9vd8SZm5i3Q/pl5rYQZhufUS789gf1WJ7N2E0R+YHlMqYr4UjcBVOwWbyUbWkRe4l+N6XMwOiRqX+WOMyIIatsC9dLCBqbbBL6/AHJH7D9Hq6WEDWSL3J1hMDmvCbGPCvhF9mwKyCBsxVaANi1Annwe61Qc/ga/XaudB3QAxmyvQklIEdWK+onCfqP6jfhijrd9Cukp8wsd+72TMf2qpSnuhptgZir2JcJT9hUgWdMqxXuqBoqaDHDgzWa4fcUbc/N2Fm57+f2hYVfes14Cal/IXZHejRtqjoW6EBfY9aucKsA55pW1TMNk8D7lHKX5gloE3bomK2Cg14XCl/YWbfabe0DRS9A3BJW1/xZEzWM3JaqUDR+x5atfUVRlU2IDqkVKC45jk80tZXGC226Yg7lQoUve3Qra2vMFqjAZsh8xMziC7o00P4CqNlMGRDjkVck9BD+Auzcjwrx0jePzn/AUUivwGpxUjCogQGFAAAAABJRU5ErkJggg==">
                                            </div>
                                            <span class="keyword">{{ __('text.borka-hijab') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>


                        <div class="navigation home">
                            <div class="clearfix">
                                <div class="h-middle">
                                    <h3>জনপ্রিয় অনুসন্ধান</h3><br>
                                    <div>
                                        @forelse($recent_search as $search_key)
                                            <span style="padding-bottom: 12px;">
                                                <a href="{{url("/search?string=$search_key->search_text")}}"
                                                   style="line-height: 40px;">{{$search_key->search_text}}</a>&nbsp; | &nbsp;
                                            </span>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection