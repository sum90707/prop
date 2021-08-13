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
</div>


<style>
  #main-content {
    /* background-color : black; */
    width: 100%;
    height:  400px;
    padding: 0;
  }

  #img-group {
    height:  400px;  
    width:   100%;  
    padding: 0;
    margin:  0;  
  }

  #img-group img {
    border:  1px solid #ccc;  
    background-color: #eee;  
    width:  100%; 
    height: 400px; 
    top:  0; 
    left: 0;
    border-radius: 10px;
  }

  #left {
    left: 0;
    animation: 1.0s leftMove;
    font-size: 50px;
    top: 200px;
    z-index: 99;
    animation-iteration-count:infinite;
    transition-timing-function: cubic-bezier(.44,.13,.36,.19);
    color: #777474bf;
    position: absolute;
  }

  #right {
    right: 0;
    animation: 1.0s rightMove;
    font-size: 50px;
    top: 200px;
    z-index: 99;
    animation-iteration-count:infinite;
    transition-timing-function: cubic-bezier(.44,.13,.36,.19);
    color: #777474bf;
    position: absolute;
  }

  .change-banner input {
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
  }

  @keyframes leftMove {
      0% {
          transform: translate3d(0px, 0px, 0px);
      }
      50% {
          transform: translate3d(10px, 0px, 0px);
      }
      100% {
          transform: translate3d(0px, 0px, 0px);
      }
  }

  @keyframes rightMove {
      0% {
          transform: translate3d(0px, 0px, 0px);
      }
      50% {
          transform: translate3d(-10px, 0px, 0px);
      }
      100% {
          transform: translate3d(0px, 0px, 0px);
      }
}   

  
</style>
<script type="text/javascript" src="{{ URL::asset('js/jquery.cycle.all.js') }}"></script>
<script>
  $(function() {
    var bannerList = ['https://banner-cfnetwork.cdn.hinet.net/image/7630/01229154e20e954a3dc2a4a299b69a0e.gif',  
                      'https://cdn.holmesmind.com/image/defbg.jpg',
                      'https://banner-cfnetwork.cdn.hinet.net/image/7630/bd7ae96e83f8bfba6c0bdb1647d29b28.gif'],
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