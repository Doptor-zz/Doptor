<div class="widget-body">
    <form class="form-horizontal">

        <fieldset>
            <legend>Company Branch</legend>
            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {!! $company->name !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Registration Number</label>
                <div class="controls">
                    {!! $company->reg_no !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    {!! $company->country->name !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    {!! $company->address !!}
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Person in-charge</legend>

            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    {!! $company->incharge->name !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    {!! $company->incharge->country->name !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    {!! $company->incharge->address !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Website</label>
                <div class="controls">
                    {!! $company->incharge->website !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    {!! $company->incharge->email !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Phone Number</label>
                <div class="controls">
                    {!! $company->incharge->phone !!}
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend></legend>
            <div class="control-group">
                <label class="control-label">Created At</label>
                <div class="controls">
                    {!! $company->created_at !!}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Updated At</label>
                <div class="controls">
                    {!! $company->updated_at !!}
                </div>
            </div>
        </fieldset>
    </form>
</div>
