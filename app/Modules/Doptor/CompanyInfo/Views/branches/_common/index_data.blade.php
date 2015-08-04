<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="span1"><input type="checkbox" class="select_all" /></th>
            <th>Name</th>
            <th>Company</th>
            <th>Country</th>
            <th>Address</th>
            <th class="span2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($company_branches as $company_branch)
            <tr>
                <td>{!! Form::checkbox($company_branch->id, 'checked', false) !!}</td>
                <td>
                    {!! HTML::link(route($link_type . '.modules.' . $module_link . '.branches.show', [$company_branch->id]), $company_branch->name) !!}
                </td>
                <td>
                    {!! HTML::link(route($link_type . '.modules.' . $module_link .'.companies.show', [$company_branch->company->id]), $company_branch->company->name) !!}
                </td>
                <td>
                    {{ $company_branch->country->name }}
                </td>
                <td>
                    {{ $company_branch->address }}
                </td>
                <td>
                    <a href="{!! route($link_type . '.modules.' . $module_link .'.branches.edit', [$company_branch->id]) !!}" class="btn btn-mini"><i class="icon-edit"></i></a>

                    <div class="actions inline">
                        <div class="btn btn-mini">
                            <i class="icon-cog"> Actions</i>
                        </div>
                        <ul class="btn btn-mini">
                            <li>
                                {!! Form::open(array('route' => array($link_type . '.modules.'.$module_link.'.branches.destroy', $company_branch->id), 'method' => 'delete', 'class'=>'inline')) !!}
                                    {!! Form::hidden('form_id', '27') !!}
                                    <button type="submit" class="danger" onclick="return deleteRecord($(this))"><i class="icon-trash"></i> Delete</button>
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
