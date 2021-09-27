@extends('layouts.main')

@section('title', __('paper.title_create'))

@section('content')

<div class="layouts pushable">
    <div class="ui main container">
        <div class="ui text container">
            <div class="ui one column grid center aligned">
                <div class="sixteen wide column ">
                    <div class="profile ui card ">
                        <div class="content">
                            <div class="four wide column center aligned">
                                <h2>
                                    @lang('quesition.title_view')
                                </h2>
                            </div>
                        </div>
                        <div class="content">

                            <table class="ui celled striped table center aligned js-table paper-table" width="100%">        
                                <thead>
                                    <tr>
                                        <th>@lang('glob.status')</th>
                                        <th>ID</th>
                                        <th>@lang('glob.name')</th>
                                        <th>@lang('glob.remark')</th>
                                        <th>@lang('glob.create_by')</th>
                                        <th>@lang('glob.operate')</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        let $dataTable = $('.paper-table').DataTable({
            autoWidth: true,
            info: false,
            lengthChange: false,
            serverSide: true,
            pageLength: 30,
            ajax: {
                'url': "{{ route('paper.list') }}",
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("token", "{{ csrf_token() }}");
                }
            },
            order: [[ 1, 'asc' ]],
            columns: [
                { 
                    data: 'status',
                    render: function (data, type, row) {

                        return `
                            <div class="ui toggle checkbox status-checkbox" 
                                data-status="${data}" 
                                data-id=${row.id}
                                data-route="{{ route('paper.toggle',['paper' => '__index__']) }}">
                                <input type="checkbox" name="public">
                                <label></label>
                            </div>`
                    }
                },
                {   
                    data: 'id',
                    render: function (data, type, row) {

                        return `
                            <div class="ui mini basic green button">
                                ${data}
                            </div>`
                    }
                    
                },
                {   
                    data: 'name'
                    
                },
                {   
                    data: 'remark'
                    
                },
                {   
                    data: 'create_by'
                    
                },
                { 
                    data: 'id',
                    render: function (data, type, row) {

                        return `
                            <div class="ui floating dropdown button">
                                @lang('paper.operate')
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item js-sidebar" data-route="{{ route('paper.form') }}/${data}">
                                        @lang('glob.update')
                                    </div>
                                </div>
                            </div>
                        `
                    }
                    
                },

            ],
            dom: `
                <'ui stackable grid'
                    <'row'
                        <'five wide column js-create-button'>
                        <'right aligned eleven wide column'f>
                    >
                    <'row dt-table'
                        <'sixteen wide column'tr>
                    >
                    <'row'
                        <'seven wide column'i>
                        <'right aligned nine wide column'p>
                    >
                >`,
            language: {!! json_encode(__('datatable.package')) !!},
            initComplete: function() {
                $('.js-create-button').html(`
                    <div class="ui floating green dropdown button" id="action-list">
                        @lang('paper.create')
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item js-sidebar" data-route="{{ route('paper.form') }}">
                                @lang('paper.general')
                            </div>
                        </div>
                    </div>
                `)

                $('#action-list').dropdown({on: 'hover'});
            },
            drawCallback: function(settings, json) {
                $('#loading').removeClass('active');
                $statusCheckBox = $('.status-checkbox');
                $statusCheckBox.checkbox();
                $('.dropdown').dropdown();
                $.each($statusCheckBox,function(){
                    setCheckBox($(this));
                    $(this).unbind('click').bind('click', statusToggle)
                })
            }
        });

        $dataTable.search($.urlParam('search')).draw();

        
           
    });


</script>
@endsection