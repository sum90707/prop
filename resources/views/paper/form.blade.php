
{{ Form::open(array('class' => 'ui form paper-form', 'method' => 'post')) }}

    <h1>
        @lang('paper.create')
    </h1>

    <div class="ui green label">
        @lang('paper.general')
    </div>
    
    <div class="ui secondary pointing menu">
        <a class="item active" data-tab="basic">@lang('glob.basic_info')</a>
    </div>

    <div class="ui tab active" data-tab="basic">

        <div class="field">
            <div class="required">
                @lang('glob.name')
            </div>
            {{ Form::text('paper[name]', $paper ? $paper->name : null) }}
        </div>

        <div class="field">
            @lang('glob.remark')
            {{ Form::text('paper[remark]', $paper ? $paper->remark : null) }}
        </div>

        <div class="row sidebar-button-group">
            <div class="ui primary button js-sidebar-save"
                 data-route="{!! route('paper.save') !!}{{ $paper ? '/' . $paper->id : ''}}"
                 >
                @lang('glob.save')
            </div>
            <div class="ui button js-sidebar-close">
                @lang('glob.discard')
            </div>
        </div>
        

    </div>
    
{{ Form::close() }}




