
@if(\App\Models\Extension::where('act', 'custom-captcha')->where('status', 1)->first())
    <div class="form-group d-flex justify-content-center">
                @php echo  getCustomCaptcha(46,'100%', '#'.$general->secondary_color, '#'.$general->base_color) @endphp
              </div><!--/.form-group-->
              <div class="form-group">
                <input type="text" name="captcha" class="form-control" placeholder=" Enter Code" autocomplete="off">
              </div><!--/.form-group-->
@endif