<?php
    $options = array( "7" => "Avata", 
              "5" => "Curry Puff", 
              "2" => "Deadpoo",
              "8" => "Dollraemon",
              "4" => "Donald Drunk", 
              "6" => "Genghis Khan",
              "1" => "Hairy Porter", 
              "3" => "Hermoney Changer",
              "10" => "Hulky",
              "11" => "Kimchi Jong-un",  
                  "9" => "Queen Kong",
                  "12" => "Super Maria" );
?>
@extends('new_template_with_side_bar')
@section('title')
Create Image
@endsection
@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.css" rel="stylesheet">
<link href="css/image-picker.css" rel="stylesheet">
<script type="text/javascript">
  //auto expand textarea
  function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
  }
</script>
@endsection
@section('main-content')
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      @if (count($errors) > 0) 
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
    <div class="col-md-8 tell-panel">
      <div class="page-content-wrapper">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title panel-tell-title">tell a different story</h3>
          </div>
          <div class="panel-body">
            <div class=" col-md-4">
              <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" 
           data-target="#imageModal">pick a snap</button>
              <!--Select image modal-->
              <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
                <div class="modal-dialog full-screen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" 
                              data-dismiss="modal" 
                              aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="imageModalLabel">Choose Image</h4>
                        </div>
                     
                        <div class="modal-body">
                          <form role="form" action="/new_create" id="chooseImageForm" method="get">
                            <div class="form-group">
                              <input name="character_id" type="hidden" value="{{$character_id}}">
                            </div>
                            <div class="form-group">
                              <select id="image_id" name="image_id" class="image-picker form-control">
                                <option value=""></option>
                                @foreach ($images as $image)
                                <option data-img-src='storage/images/{{$image->file_path}}' value='{{$image->id}}'>{{$image->file_path}}</option>
                                @endforeach
                              </select>
                            </div>
                          </form>
                        </div>  

                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <span class="pull-right">
                              <input id="submitForm" type="submit" value="Choose Image" class="btn btn-primary"/>
                          </span>
                        </div>  
                    </div>
                </div>
              </div>

              <i class="fa fa-camera-retro fa-2x" aria-hidden="true"></i>
              <div class="panel panel-danger sub-panel-position">
                <div class="panel-body notice-font">
                  Retellgram has 5 factions and 9
                  characters. Each character belongs to
                  1 of the 4 factions- Red, Yellow,
                  Green, Blue. The last faction- White
                  consists of non-fictional users. Votes
                  earned by characters contribute to the
                  total votes for each faction. Winning
                  faction gets to rule over the rest. Factions
                  get to overthrow ruler every week.
                </div>
              </div>
            </div>

            <div class=" col-md-8">
              <div class="panel panel-primary">
                <div class="panel-body">
                  @if($image_id)
                  <img class="mg-rounded" id="caption_image" src="storage/images/{{$image_path}}" alt="Image {{ $image_path }} ">
                  @else
                  <img src="images/cat.jpg" class="img-rounded">
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-4">
              @if($character_id)
              <p>Post as {{$options[(string)$character_id]}}</p>
              @else
              <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#characterModal">choose someone famous</button>
              <button type="button" class="btn btn-md btn-warning">choose to be yourself <i class="fa fa-hand-lizard-o" aria-hidden="true"></i></button>
              @endif
            </div>

            <!--Select character modal-->
              <div class="modal fade" id="characterModal" tabindex="-1" role="dialog" aria-labelledby="characterModalLabel">
                <div class="modal-dialog full-screen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" 
                              data-dismiss="modal" 
                              aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="characterModalLabel">Choose Character</h4>
                        </div>
                    

                        <div class="modal-body character-modal-body">
                          <form role="form" action="/new_create" id="chooseCharacterForm" method="get">
                            <div class="form-group">
                              <input id="image_id" name="image_id" type="hidden" value="{{$image_id}}">
                            </div>
                            <div class="form-group">
                              <select id="character_id" name="character_id" class="form-control">
                                <option value="">Select character</option>
                                @foreach ($options as $option_id => $option)
                                <option value='{{$option_id}}'>{{$option}}</option>
                                @endforeach
                              </select>
                            </div>
                            <span class="pull-right">
                              <input id="submitForm" type="submit" value="Select Character" class="btn btn-primary"/>
                            </span>
                          </form>
                        </div>  

                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>  
                    </div>
                </div>
              </div>

      
            {!! Form::open() !!}
            <div class="form-group">
              {!! Form::hidden('image_id', $image_id) !!}
            </div>

            <div class="form-group">
              {!! Form::hidden('character_id', $character_id) !!}
            </div>

            <div class=" col-md-6">
              <div class="form-group form-style-8"> 
                <textarea id="caption" name="caption" placeholder="Caption" onkeyup="adjust_textarea(this)"></textarea>
              </div>  
            </div>
            <div class="col-md-4"></div>
            <div class=" col-md-6">
              <div class="form-group form-style-8"> 
                <textarea id="hashtags" name="hashtags" placeholder="#retellgram #hashtags #maximumFiveAllowed" onkeyup="adjust_textarea(this)"></textarea>
              </div>  
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-8">
              <button type="submit" class="btn btn-lg btn-success">retell <i class="fa fa-heart" aria-hidden="true"></i></button>
            </div>
            {!! Form::close() !!}

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer')
<script type="text/javascript" src="js/image-picker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
<script>
  $(document).ready(function () {
    $('#caption_image').croppie({
      showZoomer:false,
      enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 200,
            height: 200
        }
    });
    $("#submitForm").on('click', function() {
          $("#chooseImageForm").submit();
      });
      $("#image_id").imagepicker({
          hide_select: true,
          limit: 1,
          limit_reached: function(){swal('Please select only one image.')}, 
      });
  });
</script>
@endsection