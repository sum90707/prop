@extends('layouts.main')

@section('title', __('user.change_password'))

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
<div class="layouts pushable">
    <div class="ui main container">
        <div class="ui middle aligned grid">
            <div class="column">
                <div class="ui teal image" id="header">
                    {{-- <img class="logo" src="https://cdn.holmesmind.com/dsp/logo_new.png"> --}}
                </div>

                <div class="ui stacked segment">

                    <form class="ui large form" id="change-password-form" >

                        <div class="ui error message">
                            <h1 class="header">@lang('glob.ooops') !</h1>
                            <ul class="list"></ul>
                        </div>

                        <div class="field">
                            <div class="ui left icon input">
                                @can('access', 'admin')
                                    <i class="envelope icon"></i>
                                    {{ Form::text('User[email]]', null, [
                                        'placeholder' => Lang::get('user.email'),
                                    ]) }}
                                @else
                                    <i class="envelope icon"></i>
                                    {{ Form::text('User[email]]', Auth::User()->email, [
                                        'readonly' => 'true',
                                    ]) }}
                                @endcan
                                
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                {{ Form::password('User[password]', [
                                    'placeholder' => Lang::get('user.password'),
                                    'class' => 'input-pwd'
                                ]) }}
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                {{ Form::password('User[password_confirmation]]', [
                                    'placeholder' => Lang::get('user.password_confirmation'),
                                    'class' => 'input-pwd'
                                ]) }}
                            </div>
                        </div>
                    </form>

                    <div class="field" style="margin: 2%">
                        <div class="ui text-center">
                            <button class="ui black button icon submit button change-btn">
                                <i class="save icon"></i>
                                @lang('glob.save')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(function() {
	$(".change-btn").unbind("click").click(function() {

        $("#change-password-form .error.message").hide();
        
        let data = $("#change-password-form").serializeArray(),
            loadBtn = this;
            

		$(loadBtn).addClass("loading");

		/**
		 * Send a request to the login route
		 */
		$.ajax({
			url: '{{ route("user.save.password") }}',
			type: 'POST',
			data: data,
			dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }, 		
			success: function(json) {
                if (loadBtn != null) {
                    $(loadBtn).removeClass("loading");
                }
                ajaxSussMsg(json);
                $('.input-pwd').val('');
			}
		})
		.fail(function(e) {
			if (loadBtn != null) {
				$(loadBtn).removeClass("loading");
			}

            if (e.responseJSON.message && e.responseJSON.validator) {
                if (e.responseJSON.message.length > 0 ) {
                    var errors = JSON.parse(e.responseJSON.message);

                    $("#change-password-form .error.message").show();
                    $("#change-password-form .error.message .list").html('');
                    for (var key in errors) {
                        $("#change-password-form .error.message .list").append("<li>" + errors[key][0] + "</li>");
                    }
                }
            }else{
                ajaxErrors(e);
            }
		});
		return false;
	});
})
</script>
@endsection