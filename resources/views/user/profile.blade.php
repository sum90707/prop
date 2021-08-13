@extends('layouts.main')

@section('title', __('user.profile'))

@section('content')
<style>
    .button-row {
        padding-top: 2rem;
    }
    .user-img i {
        bottom: 15px;
        position: absolute;
    }

</style>
<div class="ui main container">
    <div class="ui text container">
        <div class="ui one column grid">
            <div class="centered row user-img">
                <div class="mug-shot-group">
                    <img class="ui medium circular image" id="mug-shot" 
                        src={{ $userData->mug_shot ? asset('upload/') . "/$userData->id/$userData->mug_shot" : "https://cdn.holmesmind.com/image/defbg.jpg" }}>
                    {{-- <i class="edit icon" id="mug-shot-icon"><input type="file" name="po_image"></i> --}}
                    <i class="edit icon" id="mug-shot-icon"></i>
                    <input type="file" id="img-input" name="attachmentName" style="display: none">
                </div>
    
            </div>
            <div class="column">
                <div class="profile ui card ">
                    <div class="content">

                        {{ Form::open(array('route' => ['user.save'], 'method' => 'post', 'class' => 'ui form')) }}

                            <div class="row">
                                <div class="ui two column grid ">
                                    <div class="three wide column middle aligned">
                                        <i class="user icon"></i>
                                        @lang('user.name')
                                    </div>
                                    <div class="one wide column"></div>
                                    <div class="twelve wide column">
                                        {{ Form::text('User[name]', $userData['name']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="ui two column grid ">
                                    <div class="three wide column middle aligned">
                                        <i class="envelope icon"></i>
                                        @lang('user.email')
                                    </div>
                                    <div class="one wide column"></div>
                                    <div class="twelve wide column">
                                        {{ $userData['email'] }}
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="ui two column grid ">
                                    <div class="three wide column middle aligned">
                                        <i class="address card icon"></i>
                                        @lang('user.auth')
                                    </div>
                                    <div class="one wide column"></div>
                                    <div class="twelve wide column">
                                        {{ $userData['auth'] }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="ui two column grid ">
                                    <div class="three wide column middle aligned">
                                        <i class="language icon"></i>
                                        @lang('user.language')
                                    </div>
                                    <div class="one wide column"></div>
                                    <div class="twelve wide column">
                                        {{ Form::select('User[language]', config('languages'), $userData['language'], [
                                            'id' => 'user-language'
                                        ]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="ui two column grid ">
                                    <div class="three wide column middle aligned">
                                        <i class="hourglass end icon"></i>
                                        @lang('user.last_login')
                                    </div>
                                    <div class="one wide column"></div>
                                    <div class="twelve wide column">
                                        {{ $userData['last_login'] }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row button-row">
                                <div class="column middle aligned center aligned">
                                    <button class="ui secondary button">
                                        <i class="save icon icon"></i>
                                        @lang('glob.save')
                                    </button>
                                </div>
                            </div>
                            
                                
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var testVae = 1;
$(function() {

    var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'],
        publicPath = "{{asset('upload/')}}";
    
    $('#mug-shot-icon').on('click', function () {
        $('#img-input').click();
    });

    $('#img-input').on('change', function(event, label) {
        if ($(this).val()) {
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                ajaxErrors({
                    'status': 422,
                    'message': "Only formats are allowed : "+fileExtension.join(', ')
                });
                return
            }
            uploadImage(event.target.files);
        }
    })


    function uploadImage(file) {	
        let data = new FormData();

        if(file.length > 1){
            ajaxErrors({
                'status':422, 
                'message': 'too more files'
            });

            return
        }

        $.each(file, function(key, ofile) {
            data.append(key, ofile);
        });

        $.ajax({
            url: "{{ route('user.image') }}",
            type: 'POST',
            data: data,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }, 			
            processData: false,
            contentType: false,			
            success: function(json) {
                
                if(json.status == 200){
                    $("#mug-shot").attr("src", `${publicPath}/${json.image}`);
                }else{
                    ajaxErrors(json)
                }
            },
            error: function(e) {
                ajaxErrors(e)
            }
        });
        




       
    }


   


})

</script>
@endsection



