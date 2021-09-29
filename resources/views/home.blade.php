@extends('layouts.main')

@section('content')
<div class="ui main container">
  
  <div class="ui vertical stripe segment" id="main-content">
    <div class="banner-group" >
      <div class="row" id="img-group">
          <img  src="%%IMG_URL%%" width="100%" id="%%index%%">
      </div>
  
      <div class="change-banner" id="right"><input type="button" value="❯"> </div>
      <div class="change-banner" id="left"><input type="button" value="❮"> </div>
    </div>
  </div>


  <div class="ui two column centered grid" style="margin: auto">
    <div class="ours-teacher ui link cards four wide row" >
      
      @foreach ($teachers as $teacher)
        <div class="card teacher-card">

          <div class="image">
            <img src="{{ asset('upload/') }}/{{ $teacher->mug_shot ? $teacher->id .'/'. $teacher->mug_shot : 'teacher.png' }}">
          </div>

          <div class="content">
            <div class="header">{{ $teacher->name }}</div>
            <div class="description">{{ $teacher->introduce }}</div>
          </div>
          <div class="extra content">
            <span class="right floated">
              {{ date( "Y/m/d", strtotime($teacher->created_at)) }} 
              @lang('glob.join_at')
            </span>
          </div>
          
        </div>
      @endforeach
      
    </div>
  <div>
    

</div>


<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}">
<script type="text/javascript" src="{{ URL::asset('js/jquery.cycle.all.js') }}"></script>
<script>
  $(function() {
    var bannerList = ['https://cdn.holmesmind.com/image/defbg.jpg',  
                      'https://cdn.holmesmind.com/image/defbg.jpg',
                      'https://cdn.holmesmind.com/image/defbg.jpg'],
      $imgGroup = $('#img-group'),
      imgHtml = $('#img-group').html();


    function creatBannerCycle() {


      for(let urlIndex in bannerList){
        let imgTemplate = activePath(imgHtml, {'%%IMG_URL%%' : bannerList[urlIndex]});

        imgTemplate = activePath(imgTemplate, {'%%index%%': urlIndex})
        $imgGroup.append(imgTemplate)
      }

      setCycle();
    }

    function setCycle() {
      $('#img-group').cycle({
          slideResize: false,
          containerResize: true,
          width: '100%',
          height: '400px',
          fx: 'scrollHorz',
          next: '#right',
          prev: '#left'
        });
    }
    
    $imgGroup.html('');
    creatBannerCycle();
  })

  
</script>

@endsection