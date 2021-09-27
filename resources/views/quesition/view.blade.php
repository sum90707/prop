@extends('layouts.main')

@section('title', __('quesition.title_view'))

@section('content')

<div class="layouts pushable">
    <div class="ui main container">
        <div class="ui one column grid center aligned">
            <div class="four wide column center aligned">
                <h2>
                    @lang('quesition.title_view')
                </h2>
            </div>
            <div class="fourteen wide column">

                <table class="ui compact celled definition table center aligned">
                    <thead>
                        <tr>
                            <th></th>
                            <th> @lang('quesition.id')</th>
                            <th> @lang('quesition.year')</th>
                            <th> @lang('quesition.semester')</th>
                            <th> @lang('quesition.type')</th>
                            <th> @lang('quesition.quesition')</th>
                            <th> @lang('quesition.options') </th>
                            <th> @lang('quesition.answer')</th>
                            <th> @lang('quesition.operate')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quesitions as $quesition)
                        <tr>
                            <td>
                                <div class="ui toggle checkbox status-checkbox" 
                                    data-status="{{ $quesition->status }}" 
                                    data-id={{ $quesition->id }}>
                                    <input type="checkbox" name="public">
                                    <label></label>
                                </div>
                            </td>
                            <td> {{ $quesition->id }} </td>
                            <td> {{ $quesition->year }} </td>
                            <td> {{ $quesition->semester }} </td>
                            <td> {{ $quesition->type }} </td>
                            <td> {{ $quesition->quesition }} </td>
                            <td> 
                                @if(is_array($quesition->options))
                                    {{ Form::select('', $quesition->options, $quesition->answer, [
                                        'class' => 'ui dropdown',
                                        'id' => 'options'
                                    ]) }}
                                @else
                                    <div class="ui mini basic red button">
                                        @lang('quesition.no_options')
                                    </div>
                                @endif
                            </td>
                            <td> {{ $quesition->answer }} </td>
                            
                            <td> 
                                <div class="ui floating dropdown button">
                                    @lang('quesition.operate')
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item menu-item-btn" data-route="{{ route('quesition.create.page') }}/{{ $quesition->id }}">
                                            @lang('glob.update')
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="full-width">
                       
                    </tfoot>
                </table>
                 <div> {{ $quesitions->links() }}</div>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    $statusCheckBox = $('.status-checkbox');
    $statusCheckBox.checkbox();
    
    $('.dropdown').dropdown();
    
    $.each($statusCheckBox,function(){
        setCheckBox($(this));
        $(this).unbind('click').bind('click', toggle)
    })

})




function toggle() {
    let id = $(this).data('id'),
        $btn = $(this),
        route = "{!! route('quesition.toggle',['quesition' => '__index__']) !!}"

    $.ajax({
        url: activePath(route, {'__index__' : id}),
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }, 	
        success: function(json, textStatus, xhr) {
            ajaxSussMsg(json);
            setCheckBox($btn, json);
        }
    })
    .fail(function(xhr) {
        ajaxErrors(xhr);
    });
}
</script>


@endsection