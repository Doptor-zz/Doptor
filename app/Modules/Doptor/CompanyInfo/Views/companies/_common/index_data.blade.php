<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="span1"><input type="checkbox" class="select_all" /></th>
            <th>Name</th>
            <th>Country</th>
            <th>Address</th>
            <th>Branches</th>
            <th class="span2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($companies as $company)
            <tr>
                <td>{!! Form::checkbox($company->id, 'checked', false) !!}</td>
                <td>
                    {!! HTML::link(route($link_type . '.modules.' . $module_link .'.companies.show', [$company->id]), $company->name) !!}
                </td>
                <td>
                    {{ $company->country->name }}
                </td>
                <td>
                    {{ $company->address }}
                </td>
                <td>
                    @if (can_user_access_company($company->id))
                        <a href="{!! route($link_type . '.modules.' . $module_link . '.companies.branches', $company->id) !!}" class="btn btn-mini"><i class="icon-eye-open"></i> View</a>
                    @endif
                </td>
                <td>
                    @if (can_user_access_company($company->id))
                        <a href="{!! route($link_type . '.modules.' . $module_link .'.companies.edit', [$company->id]) !!}" class="btn btn-mini"><i class="icon-edit"></i></a>

                        <div class="actions inline">
                            <div class="btn btn-mini">
                                <i class="icon-cog"> Actions</i>
                            </div>
                            <ul class="btn btn-mini">
                                <li>
                                    {!! Form::open(array('route' => array($link_type . '.modules.'.$module_link.'.companies.destroy', $company->id), 'method' => 'delete', 'class'=>'inline')) !!}
                                        <button type="submit" class="danger" onclick="return deleteRecord($(this))"><i class="icon-trash"></i> Delete</button>
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
