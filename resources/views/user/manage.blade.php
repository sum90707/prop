@extends('layouts.main')

@section('title',  __('user.manage'))

@section('content')

<style>
    .dashboard {
        padding: 15px;
    }
</style>
<div class="layouts pushable">
    <div class="ui main container dashboard">

        <h1 class="ui header">
            @lang('user.manage')
        </h1>

        <div class="dimmable">
            <div class="ui active inverted dimmer" id="loading">
                <div class="ui text loader huge">
                    @lang('glob.loading') 
                </div>
            </div>

            <table class="ui celled striped table js-table user-manage" width="100%" style="text-align: center">        
                <thead>
                    <tr>
                        <th class="button">@lang('user.status') </th>
                        <th>
                            @lang('user.name')
                        </th>
                        <th>
                            @lang('user.email') 
                        </th>
                        <th>
                            @lang('user.auth') 
                        </th>
                        <th>
                            @lang('user.language') 
                        </th>
                        <th>
                            @lang('user.last_login') 
                        </th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>


<script>
    $(function() {
        let $dataTable = $('.js-table.user-manage').DataTable({
            autoWidth: true,
            info: false,
            lengthChange: false,
            serverSide: true,
            pageLength: 30,
            ajax: '{{ route("user.list") }}',
            order: [[ 1, 'asc' ]],
            columns: [
                { 
                    data: 'status',
                    render: function (data, type, row) {
                        return `
                            <div class="ui animated ${ toggleButtonConfig[data].color } button js-button"
                                    data-route="${ activePath(togglePathTemplate, {'__id__': row.id}) }"
                                    data-method="put"
                                    data-callback="toggleButton">
                                <div class="visible content">${ toggleButtonConfig[data].status }</div>
                                <div class="hidden content">${ toggleButtonConfig[data].event} </div>
                            </div>`
                    }
                },
                {   
                    data: 'name'
                    
                },
                { 
                    data: 'email'
                },
                { 
                    data: 'auth',
                    render: function (data, type, row) {
                        return `
                            <select class="ui dropdown auth-dropdown user-info-selector" 
                                data-route="${ activePath(authTogglePathTemplate, {'__id__': row.id}) }"
                                data-method="put"
                                style="height: 100%;width: auto">
                                <option value="teacher" ${data == 'teacher' ? selected="selected" : ''}>teacher</option>
                                <option value="student" ${data == 'student' ? selected="selected" : ''}>student</option>
                            </select>`
                    }
                },
                { 
                    data: 'language',
                    render: function (data, type, row) {
                        return `
                            <select class="ui dropdown auth-dropdown user-info-selector" 
                                data-route="${ activePath(langTogglePathTemplate, {'__id__': row.id}) }"
                                data-method="put"
                                style="height: 100%;width: auto">
                                <option value="tw" ${data == 'tw' ? selected="selected" : ''}>繁體中文</option>
                                <option value="en" ${data == 'en' ? selected="selected" : ''}>English</option>
                            </select>`
                    }
                },
                { 
                    data: 'last_login'
                }
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
            drawCallback: function(settings, json) {

                $('#loading').removeClass('active');
                $('.user-info-selector').change(function (){
                    let $select = $(this);
                        whichSelect = $select.val(),
                        route = $select.data('route'),
                        method = $select.data('method');

                    $.ajax({
                        url: `${route}?select=${whichSelect}`,
                        type: method ? method : 'get',
                        success: function(json, textStatus, xhr) {
                            ajaxSussMsg(json);
                        }
                    })
                    .fail(function(xhr) {
                        ajaxErrors(xhr);
                    });
                });

            }
        });

        $dataTable.search($.urlParam('search')).draw();

        
           
    });

    let togglePathTemplate = '{{ route("user.toggle", ["user" => "__id__"]) }}',
        authTogglePathTemplate = '{{ route("user.toggle.auth", ["user" => "__id__"]) }}',
        langTogglePathTemplate = '{{ route("user.toggle.lang", ["user" => "__id__"]) }}',
        toggleButtonConfig = [
            {
                status: '{{ __("glob.disabled") }}',
                event: '{{ __("glob.set_enable") }}',
                color: 'red'
            },
            {
                status: '{{ __("glob.enabled") }}',
                event: '{{ __("glob.set_disable") }}',
                color: 'green'
            }
        ];

    function toggleButton($button,json) {
        if (json.btn == 0) {
            $button.removeClass('green')
                    .addClass('red');

            $button.find('div:eq(0)')
                    .html(toggleButtonConfig[0].status);
            $button.find('div:eq(1)')
                    .html(toggleButtonConfig[0].event);
        } else {
            $button.removeClass('red')
                    .addClass('green');

            $button.find('div:eq(0)')
                    .html(toggleButtonConfig[1].status);
            $button.find('div:eq(1)')
                    .html(toggleButtonConfig[1].event);
        }
    }
</script>
@endsection