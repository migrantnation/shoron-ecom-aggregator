@if(@$udc_agents)
    @forelse(@$udc_agents as $each_agents)
        <div class="col-sm-6">
            <div class="m-widget4__item">
                <div class="m-widget4__img m-widget4__img--logo">
                    <img src="{{($each_agents->image!='/files/noimagefound.jpg') ? $each_agents->image : url('public/admin_ui_assets/pages/media/users/blank_avatar.png')}}"
                         alt="">
                </div>

                <div class="m-widget4__info">
                    <span class="m-widget4__title">{{@$each_agents->name_bn}}</span>
                    <br>{{@$each_agents->center_name}}<br>
                    <strong>
                        {{'Total Purchase: &nbsp;'. __('admin_text.tk.').''. number_format(@$each_agents->total_purchase, 2)}}
                        <br>
                        {{'Total Orders: '. @$each_agents->total_orders}}
                    </strong>
                </div>
            </div>
        </div>
    @empty
        <h3>Top user not found</h3>
    @endforelse
@endif