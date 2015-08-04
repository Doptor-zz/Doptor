<div class="tabbable tabbable-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab_companies" data-toggle="tab">
                Companies
            </a>
        </li>
        <li>
            <a href="#tab_branches" data-toggle="tab">
                Company Branches
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_companies">
            @include("{$module_alias}::companies._common.index_buttons")

            @include("{$module_alias}::companies._common.index_data")
        </div>

        <div class="tab-pane" id="tab_branches">
            @include("{$module_alias}::branches._common.index_buttons")

            @include("{$module_alias}::branches._common.index_data")
        </div>
    </div>
</div>
