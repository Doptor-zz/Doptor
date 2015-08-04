<div class="clearfix margin-bottom-10">
    <div class="btn-group pull-right">
        <div class="actions inline">
            <div class="btn">
                <i class="icon-cog"> Actions</i>
            </div>
            <ul class="btn">
                <li>
                    {!! Form::open(array('route' => array($link_type.'.modules.'.$module_link.'.companies.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), 'entries');")) !!}
                    {!! Form::hidden('selected_ids', '', array('class'=>'selected_ids')) !!}
                        <button type="submit" class="danger"><i class="icon-trash"></i> Delete</button>
                    {!! Form::close() !!}
                </li>
            </ul>
        </div>
    </div>
    <div class="btn-group pull-right">
        <a href="{!! route($link_type.'.modules.'.$module_link.'.companies.create') !!}" class="btn btn-success">
            Add New <i class="icon-plus"></i>
        </a>
    </div>
</div>
