<?php if (!empty($category_list)): ?>
<script>
    $(function () {
        $("#list ul").sortable({
            opacity: 0.8, cursor: 'move', update: function () {
                var order = $(this).sortable("serialize") + '&update=update';
                var url = '{{url('admin/sorting-category')}}';
                $.post(url, order, function (theResponse) {
                });
            }
        });
    });
</script>
<ul class="ui-sortable">
    <?php foreach ($category_list as $key => $eachcategory): ?>
    <li id="arrayorder_<?php echo $eachcategory['id'] ?>" class="ui-sortable-handle">
        <span class="col" style="width: 20%;">{{@$eachcategory['category_name']}}</span>
        <span class="col"
              style="width: 40%;"><?php echo $eachcategory['description'];?></span>
        <span class="col"
              style="width: 20%;text-align: center;">{{@$eachcategory['total_child']}}</span>
        <span class="col text-right">
                                                @if($eachcategory['total_child'] > 0)
                <a href="{{url('admin/category-list'). '/'. @$eachcategory['id']}}"
                   class="btn green btn-xs">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
            @else
                <a href="javascript:void(0)" class="btn green btn-xs" disabled="true">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
            @endif
            <a href="{{url('admin/edit-category'). '/'.@$eachcategory['id']}}"
               class="btn blue btn-xs">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
            <a href="javascript:void(0)" onclick="customize_category({{@$eachcategory['id']}})" class="btn red btn-xs">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                            </span>
    </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<h3 style="color: red; text-align: center;color: #555555;"> NO RESULT FOUND</h3>
<?php endif; ?>