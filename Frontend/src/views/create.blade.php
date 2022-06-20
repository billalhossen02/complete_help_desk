@extends('layouts.master')
@section('content')
<!-- MainContent -->
<section class="m-profile setting-wrapper">
    <div class="container-fluid">
        <!-- <h4 class="main-title mb-4">My Account</h4> -->
        <form action="{{ route('member.auth.store.ticket',[app()->getLocale()]) }}" method="POST" enctype="multipart/form-data">
            @csrf()
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="sign-user_card text-center">
                          <div class="image-change">
                            @if(count($user->images)>0)
                                <img src="{{url('storage/'.$user->images[0]->thumbnail)}}" class="img-fluid d-block mx-auto mb-3" alt="{{$user->name}}" id="image">
                            @else
                                <img src="{{ Gravatar::src('https://www.gravatar.com/avatar/', 150) }}" class="img-fluid d-block mx-auto mb-3" alt="{{$user->name}}" id="image">
                                {{--  <img src="https://visualpharm.com/assets/30/User-595b40b85ba036ed117da56f.svg" class="img-fluid d-block mx-auto mb-3" alt="{{$user->name}}" id="image">  --}}
                            @endif

                                {{-- <input name="image"class="form_gallery-upload" type="file" accept=".png, .jpg, .jpeg" value="{{ old('image') }}" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" > --}}
                        </div>
                        <h4 class="my-3">{{$user->name}}</h4>
                        @include('member.profile.common.member-profile-menu')
                    </div>
                </div>
                            <div class="col-lg-6">
                                <div class="sign-user_card">
                                    <h5 class="mb-3 pb-3 a-border h4">Open Ticket</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <input type="hidden" value="{{ $user->name }}" name="name">
                                        <label for="name">Name</label>
                                        <p>{{$user->name}}</p>
                                        @if(!$user->name)
                                        <input type="text" class="form-control" name="name" placeholder="Enter Your Name">
                                        @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="hidden" value="{{ $user->email }}" name="email">
                                        <p>{{$user->email}}</p>
                                        @if(!$user->email)
                                        <input type="email" class="form-control" name="email" placeholder="Enter Your Email">
                                        @endif
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputState">Support Type</label>
                                            <select id='department' name="department" onChange="update()" class="form-control" required >
                                                <option value="Technical Support" selected style="background-color: #000">Technical Support </option>
                                                <option value="Refund Support" style="background-color: #000">Refund Support</option>
                                                <option value="Sales and Billings Support" style="background-color: #000">Sales and Billings Support</option>
                                                <option value="General Enquiries Support" style="background-color: #000">General Enquiries Support </option>
                                                <option value="Others" style="background-color: #000">Others</option>

                                            </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputState">Priority</label>
                                                <select name='priority' class="form-control" required>
                                                    <option selected style="background-color: #000">High</option>
                                                    <option style="background-color: #000">Medium</option>
                                                    <option style="background-color: #000">Low</option>
                                                </select>
                                                </div>
 
                                    </div>
                               
                                    <div class="form-group" id="subject">
                                        <label for="subject" >Subject</label>
                                        <input name="subject" type="text" class="form-control" id="inputAddress" placeholder="Subject">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea4">Message</label>
                                        <textarea name="message" class="form-control" id="exampleFormControlTextarea4" rows="4" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Attachments</label><br>
                                        <input type="file" accept=".jpg,.png,.pdf" name="attachment" id="exampleFormControlFile1" multiple style="cursor: pointer"> 
                                    </div>
                                    

                                    <button type="submit" class="btn btn-success" style="float: right">Send</button>
                            
                          </div>
                      </div>
                </div>
            </div>
        </form>
    </div>    
   
</section>

<script>
    
    document.getElementById("subject").style.display = "none";
    
    function update() {
				var select = document.getElementById('department');
				var option = select.options[select.selectedIndex];

				var data = option.value;

                if(data == 'Others'){
                    document.getElementById("subject").style.display = "block";
                }
                else{
                    document.getElementById("subject").style.display = "none";
                }
			}

			update();

</script>
<!-- MainContent End-->
@endsection

