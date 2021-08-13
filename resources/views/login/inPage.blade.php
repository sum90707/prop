@extends('layouts.main')

@section('title', 'Login')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">

<div class="ui main container">
    <div id="welcome" class="ui basic modal">
        <div class="ui icon header">
            <i class="child icon"></i>
            @lang('glob.welcome')
        </div>
        <div class="content text-center">
            @lang('glob.loginNow')
        </div>
    </div>
    

    <div class="ui middle aligned grid">
        <div class="column">
            <form class="ui large form" id="login-form" method="post" action="{{ route('login') }}">
                <div class="ui teal image" id="header">
                    {{-- <img class="logo" src="https://cdn.holmesmind.com/dsp/logo_new.png"> --}}
                </div>

                {{-- Display error messages and change throught javascript --}}
                <div class="ui error message">
                    <h1 class="header">ooops!</h1>
                    <ul class="list">
    
                    </ul>
                </div>	
    
                {{-- Display information from url parameter f --}}
                @if (isset($_GET['f']) && !$errors->any())
                    <div class="ui info visible message">
                        <ul class="list">
                            <li>@lang('login.' . $_GET['f'])</li>
                        </ul>
                    </div>	
                @endif	
    
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" placeholder="@lang('user.email')">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="@lang('user.password')">
                        </div>
                    </div>
                    <div class="ui">
                        <button class="ui fluid large teal submit button login-btn">
                            <i class="sign in alternate icon"></i>
                            @lang('user.login')
                        </button>
    
                        {{-- <a class="ui submit button" href="{{route('forgetPassword')}}">
                            <i class="question icon"></i>
                            @lang('login.forgetPw')
                        </a> --}}
    
                    </div>
                </div>
            </form>
        </div>
    </div>
    

    <!-- <div class="ui message">
	<h1 class="header">@lang('login.loginByOtherService')</h1>
	<button class="ui google plus button">
	 	<i class="google icon"></i>
            @lang('login.googleBtn')
        </button>
    </div> -->

    <div class="ui small link list text-center">
        Copyright © 2018 Powered by HL. All rights reserved.
    </div>

</div>






<script type="text/javascript">
$(function() {
	$(".login-btn").unbind("click").click(function() {
        $("#login-form .error.message").hide();
		var route = $("#login-form").prop("action");
        var data = $("#login-form").serializeArray();
        loadBtn = this;
		$(loadBtn).addClass("loading");
		
		/**
		 * Send a request to the login route
		 */
		$.ajax({
			url: '{{ route("login") }}',
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

				if (json.status == 200) {	

					$("#welcome").modal('show');
					setTimeout(function() {
						document.location.href = json.url;
					}, 1000);	

				} else {
					$("#login-form .error.message .list").html("");
                    $("#login-form .error.message").show();
                    $("#login-form .error.message .list").append("<li>" + json.message + "</li>");				
				}
			}
		})
		
		.fail(function(e) {
			if (loadBtn != null) {
				$(loadBtn).removeClass("loading");
			}
			ajaxErrors(e);
		});
		return false;
	});		
})
</script>
@endsection