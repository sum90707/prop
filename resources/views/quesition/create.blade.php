@extends('layouts.main')

@section('title', __('quesition.title_create'))

@section('content')

<div class="layouts pushable">
    <div class="ui main container">
        <div class="ui text container">
            <div class="ui one column grid center aligned">
                <div class="twelve wide column ">
                    <div class="profile ui card ">
                        <div class="content">

                            {{ Form::open(array('method' => 'post', 'class' => 'ui form', 'id' => 'quesition-form')) }}

                                @if($quesition->exists)
                                    <div class="row">
                                        <div class="column middle aligned center aligned">
                                            <h2> @lang('quesition.update') : {{ $quesition->id }}</h2>
                                            {{ Form::hidden('quesition[id]', $quesition->id ) }}
                                        </div>
                                    </div>
                                @endif


                                <div class="row">
                                    <div class="ui two column grid ">
                                        <div class="two wide column"></div>
                                        <div class="three wide column middle aligned">
                                            <i class="calendar alternate outline icon"></i>
                                            @lang('quesition.year')
                                        </div>
                                        <div class="two wide column"></div>
                                        <div class="nine wide column left aligned">
                                            <div class="full wide">
                                                {{ Form::select('quesition[year]', config('quesition.year'), $quesition->year , [
                                                    'class' => 'ui dropdown',
                                                    'id' => 'year-list'
                                                ]) }}
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="ui two column grid ">
                                        <div class="two wide column"></div>
                                        <div class="three wide column middle aligned">
                                            <i class="calendar icon"></i>
                                            @lang('quesition.semester')
                                        </div>
                                        <div class="two wide column"></div>
                                        <div class="nine wide column left aligned">
                                            {{ Form::select('quesition[semester]', [1 => 1, 2 => 2], $quesition->semester, [
                                                'class' => 'ui dropdown',
                                                'id' => 'semester-list'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="ui two column grid ">
                                        <div class="two wide column"></div>
                                        <div class="three wide column middle aligned">
                                            <i class="newspaper icon"></i>
                                            @lang('quesition.type')
                                        </div>
                                        <div class="two wide column"></div>
                                        <div class="nine wide column left aligned">
                                            {{ Form::select('quesition[type]', config('quesition.type'), $quesition->type, [
                                                'class' => 'ui dropdown',
                                                'id' => 'type-list'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="ui two column grid ">
                                        <div class="two wide column"></div>
                                        <div class="three wide column middle aligned">
                                            <i class="sticky note outline icon"></i>
                                            @lang('quesition.quesition')
                                        </div>
                                        <div class="two wide column"></div>
                                        <div class="nine wide column left aligned">
                                            {{ Form::textarea('quesition[quesition]', $quesition->quesition, [
                                                'id' => 'quesition',
                                                'rows' => 5, 
                                                'cols' => 40,
                                                'maxlength' => '200',
                                                'placeholder' => '200 words or less'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="option-row">
                                    <div class="ui two column grid ">
                                        <div class="two wide column"></div>
                                        <div class="three wide column middle aligned">
                                            <i class="list ol icon"></i>
                                            @lang('quesition.options')
                                        </div>
                                        <div class="two wide column"></div>
                                        <div class="nine wide column">
                                            <div class="row">
                                                <div class="ui two column grid ">
                                                    <div class="twelve wide column left aligned">
                                                        {{ Form::text('quesition[options][1]', null, ['id' => 'option-value'])}}
                                                    </div>
                                                    <div class="four wide column left aligned">
                                                        <div class="ui icon blue button" id="options-add">
                                                            <i class="icon plus"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="ui two column grid ">
                                        <div class="two wide column"></div>
                                        <div class="three wide column middle aligned">
                                            <i class="newspaper icon"></i>
                                            @lang('quesition.answer')
                                        </div>
                                        <div class="two wide column"></div>
                                        <div class="nine wide column left aligned">
                                            {{ Form::select('quesition[answer]', [], $quesition->answer, [
                                                'class' => 'ui dropdown',
                                                'id' => 'answer'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row button-row">
                                    <div class="column middle aligned center aligned">
                                        <div class="ui green button" id="save-btn">
                                            <i class="save icon"></i>
                                            @if ($quesition->exists)
                                                @lang('glob.update')
                                            @else
                                                @lang('glob.save')
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                    
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
$(function() {

    let optionsTemplate = `
        <div class="row">
            <div class="ui two column grid ">
                <div class="twelve wide column left aligned">
                    {{ Form::text('quesition[options][__index__]', null, ['id' => 'option-value'])}}
                </div>
                <div class="four wide column left aligned">
                    <div class="ui icon red button options-minus">
                        <i class="minus icon"></i>
                    </div>
                </div>
            </div>
        </div>`,
        optionsNum = 1;

    $('.ui.dropdown').dropdown();
    $('#options-add').on('click',addOptions);
    $('#type-list').on('change', handdleOptions);
    $('#option-row').on('keyup',setAnswerValue);
    $('#save-btn').on('click', save);
    handdleOptions();
    setAnswerValue();

    @if($quesition->exists)
        let data =  {!! json_encode($quesition->toArray()) !!};
        backfill(data);
        console.log(data)
    @endif

    function addOptions() {
        let $optionGroup = $(this).closest('.row').parent(),
            optionsAmount = $optionGroup.children().length,
            addBtn = $('#options-add');

        if(optionsAmount <  6){
            optionsNum++;
            let template =  activePath(optionsTemplate, {'__index__' : optionsNum});
            $optionGroup.append(template);
            bindEvent();
            $optionGroup.children().length < 6 ? addBtn.show(): addBtn.hide();
        }

    }

    function bindEvent() {
        $('#option-row').unbind('keyup').on('keyup',setAnswerValue);
        $('.options-minus').unbind('click').on('click', function () {
            $(this).closest('.row').remove();
            $('#options-add').show();
        });
    }

    function handdleOptions() {
        if($('#type-list').val() == 0){
            $('#option-row').show();
            setAnswerValue();
        }else{
            $('#option-row').hide();
            $('#answer').empty();
            $('#answer').html(`<option value="0">X</option><option value="1">O</option>`);
        }
    }

    function setAnswerValue() {
        let allAnswer = $('#option-row input[type=text]'),
            answerList = {},
            optionsTag = '';
            
        if($('#type-list').val() == 1 ){
            $('#answer').html(`<option value="0">X</option><option value="1">O</option>`);
        }else{
            $.each(allAnswer,function () {
                let value = $(this).val();
                optionsTag += `<option value="${value}">${value}</option>`
                
            })
            $('#answer').empty();
            $('#answer').html(optionsTag);
        }  
    }

   

    function save() {	

        let data = $('#quesition-form').serializeArray();
        
        $.ajax({
            url: "{{ route('quesition.save') }}",
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }, 			
            success: function(json, textStatus, xhr) {
                ajaxSussMsg(json);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        })
        .fail(function(xhr) {
            ajaxErrors(xhr);
        });
       
    }

    function backfill(data) {
        if(data.type == 0) {
            setOptions(data);
        }
        $('#answer').val(data.answer)
    }

    function setOptions(data) {
        let options = JSON.parse(data.options),
            optionsLen = Object.keys(options).length;
            valueArr = [],
            $row = $('#option-row');

        for(i=1; i < optionsLen ; i++){
            $('#options-add').click()
        }

        $.each(options,function(index) {
            valueArr.push(options[index])
        })
        
        $.each($row.find('input'),function(index) {
            $(this).val(valueArr[index]);
        })
        setAnswerValue();
    }
	
});




</script>
<style>
    .ui.dropdown.selection {
        width: 100%;
    }
    .ui.text.container {
        padding-top: 15%;
    }
</style>
@endsection