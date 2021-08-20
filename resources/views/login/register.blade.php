@extends('layouts.main')

@section('title', __('user.register'))

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
<div class="layouts pushable">
    <div class="ui main container">
        <div class="ui middle aligned grid">
            <div class="column">
                <form class="ui large form" id="register-form" method="post" action="{{ route('register') }}">
                    <div class="ui teal image" id="header">
                        {{-- <img class="logo" src="https://cdn.holmesmind.com/dsp/logo_new.png"> --}}
                    </div>

                    {{-- Display error messages and change throught javascript --}}
                    <div class="ui error message">
                        <h1 class="header">@lang('glob.ooops') !</h1>
                        <ul class="list">
        
                        </ul>
                    </div>	

                    <div class="ui stacked segment">

                        <div class="field">
                            <div class="ui left icon input">
                                <i class="user circle icon"></i>
                                <input type="text" name="name" placeholder="@lang('user.name')">
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui left icon input">
                                <i class="envelope icon"></i>
                                <input type="text" name="email" placeholder="@lang('user.email')">
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" id="password" placeholder="@lang('user.password')">
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password_confirmation" id="password" placeholder="@lang('user.password_confirmation')">
                            </div>
                        </div>

                        <div class="ui text-center">
                            <button class="ui black button icon submit button register-btn">
                                <i class="registered icon"></i>
                                @lang('user.register')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
	
	$(".register-btn").unbind("click").click(function() {

        $("#register-form .error.message").hide();
        
        let data = $("#register-form").serializeArray(),
            loadBtn = this;
            

		$(loadBtn).addClass("loading");

		/**
		 * Send a request to the login route
		 */
		$.ajax({
			url: '{{ route("register") }}',
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

                if(json.url) {
                    document.location.href = json.url;
                }
			}
		})
		.fail(function(e) {
			if (loadBtn != null) {
				$(loadBtn).removeClass("loading");
			}

            if (e.responseJSON.message) {
                if (e.responseJSON.message.length > 0) {
                    var errors = JSON.parse(e.responseJSON.message);
                    $("#register-form .error.message").show();
                    for (var key in errors) {
                        $("#register-form .error.message .list").append("<li>" + errors[key][0] + "</li>");
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